<?php

namespace PCLab\Compatibility\Helpers;

use Fhaculty\Graph\Edge\Base as Edge;
use Fhaculty\Graph\Graph;
use Fhaculty\Graph\Vertex;
use Generator;
use Illuminate\Support\Collection;
use PCLab\Compatibility\Contracts\ComparatorServiceContract;
use PCLab\Compatibility\Contracts\ComponentRepositoryContract;
use PCLab\Compatibility\Contracts\IncompatibilityGraphContract;
use PCLab\Models\ComponentChild;

class IncompatibilityGraph implements IncompatibilityGraphContract
{
    /** @var ComparatorServiceContract $comparatorService */
    private $comparatorService;

    /** @var ComponentRepositoryContract $componentRepo */
    private $componentRepo;

    /** @var Collection */
    private $requiredTypes;

    public function __construct(ComparatorServiceContract $comparatorService, ComponentRepositoryContract $componentRepo)
    {
        $this->comparatorService = $comparatorService;
        $this->componentRepo = $componentRepo;

        $this->requiredTypes = $componentRepo
            ->get()
            ->where('parent.type.is_always_required', true)
            ->pluck('parent.type.name');
    }

    public function build(Collection $components): Graph
    {
        return $this->buildTrue($this->buildBase($components));
    }

    /**
     * Builds a base incompatibility graph from the given components. The returned graph does not contain indirect
     * incompatibilities, only direct ones.
     *
     * @param Collection $components
     *
     * @return Graph
     */
    public function buildBase(Collection $components): Graph
    {
        $g = new Graph();

        // create component vertices in $g
        $vertices = $components
            ->map(function (ComponentChild $component) use ($g) {
                $v = $g->createVertex($component->parent->id);

                GraphUtils::setVertexComponent($v, $component);

                return $v;
            })
            ->all();

        // create edges between directly incompatible component vertices
        for ($i = 0; $i < count($vertices) - 1; $i++) {
            /** @var Vertex $v1 */
            $v1 = $vertices[$i];
            $c1 = GraphUtils::getVertexComponent($v1);

            for ($j = $i + 1; $j < count($vertices); $j++) {
                /** @var Vertex $v2 */
                $v2 = $vertices[$j];
                $c2 = GraphUtils::getVertexComponent($v2);

                if ($this->comparatorService->isIncompatible($c1, $c2)) {
                    $v1->createEdge($v2);
                }
            }
        }

        return $g;
    }

    /**
     * Builds a true incompatibility graph on top of the given base graph. The returned graph contains both direct and
     * indirect incompatibilities.
     *
     * @param Graph $g a base incompatibility graph
     *
     * @return Graph
     */
    public function buildTrue(Graph $g): Graph
    {
        $gOriginal = $g->createGraphClone();
        $gComplement = GraphUtils::complement($g);

        // deal with non-edges in $g and test for true compatibility
        /** @var Edge $e */
        foreach ($gComplement->getEdges() as $e) {
            $v1 = $e->getVertices()->getVertexFirst();
            $v2 = $e->getVertices()->getVertexLast();

            if (!$this->isTrulyCompatible($gOriginal, $v1, $v2)) {
                // create incompatibility edge in $g
                $g->getVertex($v1->getId())->createEdge($g->getVertex($v2->getId()));
            }
        }

        return $g;
    }

    /**
     * Returns true if the given component vertices are truly compatible. This tests for indirect incompatibilities as
     * well. The component vertex arguments should be vertices from the complement of $g.
     *
     * @param Graph $g
     * @param Vertex $v1 the starting vertex from $g's complement
     * @param Vertex $v2 the endpoint vertex from $g's complement
     *
     * @return bool
     */
    public function isTrulyCompatible(Graph $g, Vertex $v1, Vertex $v2): bool
    {
        $c1 = GraphUtils::getVertexComponent($v1);
        $c2 = GraphUtils::getVertexComponent($v2);
        $c1TypeName = $c1::typeName();
        $c2TypeName = $c2::typeName();

        $requiredTypes = $this->requiredTypes
            ->filter(function (string $typeName) use ($c1TypeName, $c2TypeName) {
                return $typeName !== $c1TypeName && $typeName !== $c2TypeName;
            })
            ->all();

        $pairs1 = $this->getCompatibleComponents($v1, $requiredTypes);
        $pairs2 = $this->getCompatibleComponents($v2, $requiredTypes);
        $pairsIntersection = $this->getPairsIntersection($pairs1, $pairs2);
        $tuples = $this->getCartesianProduct($pairsIntersection);

        return $this->isAnyTupleCompatible($g, [$c1, $c2], $tuples);
    }

    /**
     * Returns true if all components in any given tuple are directly compatible with each other.
     *
     * @param Graph $g
     * @param array $endpointsTuple
     * @param iterable $tuples
     * @param bool $expanded
     *
     * @return bool
     * @see isTupleCompatible
     */
    private function isAnyTupleCompatible(Graph $g, array $endpointsTuple, iterable $tuples, bool $expanded = false): bool
    {
        foreach ($tuples as $tuple) {
            if ($this->isTupleCompatible($g, $tuple)) {
                return $expanded
                    || empty($expandedTuple = $this->expandTuple($endpointsTuple, $tuple))
                    || $this->isAnyTupleCompatible($g, $endpointsTuple, $expandedTuple, true);
            }
        }

        return false;
    }

    /**
     * Returns true if all components in the given tuple are directly compatible with each other.
     *
     * @param Graph $g
     * @param array $tuple
     *
     * @return bool
     */
    private function isTupleCompatible(Graph $g, array $tuple): bool
    {
        for ($i = 0; $i < count($tuple) - 1; $i++) {
            $c = $tuple[$i];

            for ($j = $i + 1; $j < count($tuple); $j++) {
                if ($this->isIncompatible($g, $c, $tuple[$j])) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Gets an array of tuples that contain the given endpoint components, the original components, and any components
     * that are additionally required by one or more of the original components.
     *
     * @param ComponentChild[] $endpointsTuple
     * @param ComponentChild[] $tuple
     *
     * @return array
     */
    private function expandTuple(array $endpointsTuple, array $tuple): array
    {
        $extraTypes = [];
        $extraTuples = collect();

        /** @var ComponentChild $component */
        foreach ($tuple as $component) {
            foreach ($component->getRequiredComponentTypes() as $extraType) {
                $extraTypes[] = $extraType;
            }
        }

        // remove duplicates
        $extraTypes = array_merge(array_flip(array_flip($extraTypes)));

        foreach ($extraTypes as $extraType) {
            $extraTuples = $this->componentRepo
                ->get()
                ->filter(function (ComponentChild $component) use ($extraType) {
                    return $component->type()->name === $extraType;
                })
                ->map(function (ComponentChild $component) use ($tuple, $endpointsTuple) {
                    return array_values(array_unique(array_merge($tuple, [$component], $endpointsTuple), SORT_REGULAR));
                })
                ->merge($extraTuples);
        }

        return $extraTuples->all();
    }

    /**
     * Gets the intersection of two maps with component types as keys and component arrays as values. The returned array
     * contains arrays with intersecting components of the same type.
     *
     * @param array $pairs1
     * @param array $pairs2
     *
     * @return array[]
     */
    private function getPairsIntersection(array $pairs1, array $pairs2): array
    {
        array_walk_recursive($pairs2, function (&$component) {
            $component = $component->parent->id;
        });

        $intersections = [];

        foreach ($pairs1 as $type => $compatible) {
            $intersections[$type] = [];

            foreach ($compatible as $c1) {
                if (in_array($c1->parent->id, $pairs2[$type] ?? [])) {
                    $intersections[$type][] = $c1;
                }
            }
        }

        return array_values($intersections);
    }

    /**
     * Gets the Cartesian product of the given array of arrays.
     *
     * @param array[] $arrays
     *
     * @return Generator
     */
    private function getCartesianProduct(array $arrays): Generator
    {
        // multiply the sizes of the arrays; if any array is empty, no tuples will (or should) be generated
        $max = array_reduce($arrays, function (int $product, array $array) {
            return $product * count($array);
        }, 1);

        for ($i = 0; $i < $max; $i++) {
            $tuple = [];
            $product = 1;

            /** @var array $array */
            foreach ($arrays as $array) {
                $tuple[] = $array[$i / $product % count($array)];
                $product *= count($array);
            }

            yield $tuple;
        }
    }

    /**
     * Returns true if the given components are incompatible according to $g. That is, there is an edge between the
     * components' vertices in the graph.
     *
     * @param Graph $g
     * @param ComponentChild $c1
     * @param ComponentChild $c2
     *
     * @return bool
     */
    private function isIncompatible(Graph $g, ComponentChild $c1, ComponentChild $c2): bool
    {
        return $c1 !== $c2 && $g->getVertex($c1->parent->id)->hasEdgeTo($g->getVertex($c2->parent->id));
    }

    /**
     * Gets compatible components of the given vertex, keyed by their types. Only components with a type found in $types
     * will be returned.
     *
     * @param Vertex $v
     * @param array $types
     *
     * @return array
     */
    private function getCompatibleComponents(Vertex $v, array $types): array
    {
        $compatibleComponents = [];

        /** @var Vertex $adjacent */
        foreach ($v->getVerticesEdge()->getVerticesDistinct() as $adjacent) {
            $adjacentComponent = GraphUtils::getVertexComponent($adjacent);
            $adjacentComponentType = $adjacentComponent::typeName();

            if (in_array($adjacentComponentType, $types)) {
                $compatibleComponents[$adjacentComponentType][] = $adjacentComponent;
            }
        }

        return $compatibleComponents;
    }
}