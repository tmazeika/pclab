<?php

namespace PCForge\Compatibility\Helpers;

use Fhaculty\Graph\Edge\Base as Edge;
use Fhaculty\Graph\Graph;
use Fhaculty\Graph\Vertex;
use Illuminate\Support\Collection;
use PCForge\Compatibility\Contracts\ComparatorServiceContract;
use PCForge\Compatibility\Contracts\ComponentRepositoryContract;
use PCForge\Compatibility\Contracts\IncompatibilityGraphContract;
use PCForge\Models\ComponentChild;

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
            });

        // create edges between directly incompatible component vertices
        for ($i = 0; $i < $vertices->count() - 1; $i++) {
            /** @var Vertex $v1 */
            $v1 = $vertices->get($i);
            $c1 = GraphUtils::getVertexComponent($v1);

            for ($j = $i + 1; $j < $vertices->count(); $j++) {
                /** @var Vertex $v2 */
                $v2 = $vertices->get($j);
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
        $gC = GraphUtils::complement($g);
        $newEdges = [];

        // deal with non-edges in $g and test for true compatibility
        /** @var Edge $e */
        foreach ($gC->getEdges() as $e) {
            list($v1, $v2) = $this->getEdgeVertices($e);

            if (!$this->isTrulyCompatible($g, $v1, $v2)) {
                // queue incompatibility edge in $g
                $newEdges[] = [$v1, $v2];
            }
        }

        // add new edges to $g
        /**
         * @var Vertex $v1
         * @var Vertex $v2
         */
        foreach ($newEdges as list($v1, $v2)) {
            // switch from $gC to $g vertices
            list($v1, $v2) = $this->getVerticesFrom($g, $v1, $v2);

            // prevent duplicates
            if (!$v1->hasEdgeTo($v2)) {
                $v1->createEdge($v2);
            }
        }

        return $g;
    }

    // TODO: optimize... a lot
    /**
     * Gets whether or not the given vertices are truly compatible.
     *
     * @param Graph $g
     * @param Vertex $v1 the starting vertex from $g's complement
     * @param Vertex $v2 the endpoint vertex from $g's complement
     *
     * @return bool
     */
    public function isTrulyCompatible(Graph $g, Vertex $v1, Vertex $v2): bool
    {
        //$nowConst = microtime(true);
        //$now = $nowConst;
        //\Log::debug('');

        $c1 = GraphUtils::getVertexComponent($v1);
        $c2 = GraphUtils::getVertexComponent($v2);
        $c1TypeName = $c1::typeName();
        $c2TypeName = $c2::typeName();

        //$now = $this->timeCheckpoint($now, 1);

        $requiredTypes = $this->requiredTypes
            //->whereNotIn('parent.type.name', [$c1::typeName(), $c2::typeName()])
            ->filter(function (string $typeName) use ($c1TypeName, $c2TypeName) {
                return $typeName !== $c1TypeName && $typeName !== $c2TypeName;
            })
            ->all();

        //$now = $this->timeCheckpoint($now, 2);

        $pairs1 = $this->getCompatibleOfTypes($v1, $requiredTypes);
        $pairs2 = $this->getCompatibleOfTypes($v2, $requiredTypes);

        //$now = $this->timeCheckpoint($now, 3);

        $pairsIntersection = $this->getPairsIntersection($pairs1, $pairs2);

        //$now = $this->timeCheckpoint($now, 4);

        $tuples = $this->getCartesianProduct(...array_values($pairsIntersection));

        //$now = $this->timeCheckpoint($now, 5);

        ///**
        // * @var int $key
        // * @var ComponentChild[] $tuple
        // */
        //foreach ($tuples as &$tuple) {
        //    $additionalRequirements = $this->getAdditionalRequirements($tuple);
        //
        //    echo json_encode($additionalRequirements) . PHP_EOL;
        //    $components
        //        ->whereIn('parent.type.name', $additionalRequirements)
        //        ->each(function (ComponentChild $component) use (&$tuples, $tuple, $c1, $c2) {
        //            $tuples[] = array_merge($tuple, $component, [$c1, $c2]);
        //        });
        //
        //    if (empty($additionalRequirements)) {
        //        $tuple = array_merge($tuple, [$c1, $c2]);
        //    } else {
        //        unset($tuple);
        //    }
        //}

        //$tuples = array_flatten(array_map(function (array $tuple) {
        //    $arr = [];
        //
        //    /** @var ComponentChild $component */
        //    foreach ($tuple as $component) {
        //        $types = $component->getRequiredComponentTypes();
        //
        //        if (!empty($types)) {
        //            /** @var string $type */
        //            foreach ($types as $type) {
        //                $this->componentRepo->get()->where('parent.type.name')
        //            }
        //        }
        //    }
        //}, $tuples));

        return $this->isAnyTupleCompatible($g, [$c1, $c2], $tuples);
    }

    /**
     * @param Graph $g
     * @param array $endpointsTuple
     * @param array[] $tuples
     * @param bool $expanded
     *
     * @return bool
     */
    private function isAnyTupleCompatible(Graph $g, array $endpointsTuple, array $tuples, bool $expanded = false): bool
    {
        foreach ($tuples as $tuple) {
            if ($this->isTupleCompatible($g, $tuple)) {
                $expandedTuple = $this->expandTuple($endpointsTuple, $tuple);

                return $expanded || empty($expandedTuple) || $this->isAnyTupleCompatible($g, $endpointsTuple, $expandedTuple, true);
            }
        }

        return false;
    }

    private function isTupleCompatible(Graph $g, array $tuple): bool
    {
        for ($i = 0; $i < count($tuple) - 1; $i++) {
            $c1 = $tuple[$i];

            for ($j = $i + 1; $j < count($tuple); $j++) {
                $c2 = $tuple[$j];

                if ($this->isIncompatible($g, $c1, $c2)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @param ComponentChild[] $endpointsTuple
     * @param ComponentChild[] $tuple
     *
     * @return array
     */
    private function expandTuple(array $endpointsTuple, array $tuple): array
    {
        $extraTypes = [];
        $extraTuples = [];

        /** @var ComponentChild $component */
        foreach ($tuple as $component) {
            foreach ($component->getRequiredComponentTypes() as $extraType) {
                if (!in_array($extraType, $extraTypes)) {
                    $extraTypes[] = $extraType;
                }
            }
        }

        /** @var string $type */
        foreach ($extraTypes as $type) {
            $extraComponents = $this->componentRepo->get()->where('parent.type.name', $type);

            /** @var ComponentChild $extraComponent */
            foreach ($extraComponents as $extraComponent) {
                $extraTuples[] = array_values(array_unique(array_merge($tuple, [$extraComponent], $endpointsTuple), SORT_REGULAR));
            }
        }

        return $extraTuples;
    }

    private function dumpComponentsArray(array $components) {
        array_walk_recursive($components, function (&$component) {
            $component = $component->parent->id;
        });

        echo json_encode($components) . PHP_EOL;
    }

    private function getPairsIntersection(array $pairs1, array $pairs2): array
    {
        array_walk_recursive($pairs2, function (&$component) {
            $component = $component->parent->id;
        });

        $arr = [];

        foreach ($pairs1 as $type => $compatible) {
            $arr[$type] = [];

            foreach ($compatible as $c1) {
                if (in_array($c1->parent->id, $pairs2[$type] ?? [])) {
                    $arr[$type][] = $c1;
                }
            }
        }

        return $arr;
    }

    private function timeCheckpoint(float $previous, int $checkpoint): float
    {
        $now = microtime(true);

        \Log::debug('Checkpoint ' . $checkpoint . ': ' . number_format($now - $previous, 10) . ' s');

        return $now;
    }

    private function getCartesianProduct(array ...$arrays): array
    {
        if (empty($arrays)) {
            return [[]];
        }

        $firstArray = array_shift($arrays);
        $otherArrays = $this->getCartesianProduct(...$arrays);
        $result = [];

        foreach ($firstArray as $value) {
            foreach ($otherArrays as $anotherArray) {
                $result[] = array_merge([$value], $anotherArray);
            }
        }

        return $result;
    }

    /**
     * Gets whether or not the given components are incompatible according to the given graph $g. That is, there is an
     * edge between the component's vertices in the graph.
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
     * Gets a map of components that are compatible with the given vertex component. The types of the components must be
     * found within the given $types array, and the map is keyed by the type.
     *
     * @param Vertex $v
     * @param array $types
     *
     * @return array
     */
    private function getCompatibleOfTypes(Vertex $v, array $types): array
    {
        $arr = [];

        /** @var Vertex $adjacent */
        foreach ($v->getVerticesEdge()->getVerticesDistinct() as $adjacent) {
            $adjacentComponent = GraphUtils::getVertexComponent($adjacent);
            $adjacentComponentType = $adjacentComponent::typeName();

            if (in_array($adjacentComponentType, $types)) {
                $arr[$adjacentComponentType][] = $adjacentComponent;
            }
        }

        return $arr;
    }

    /**
     * Gets an array of $e's vertices.
     *
     * @param Edge $e
     *
     * @return array
     */
    private function getEdgeVertices(Edge $e): array
    {
        $eVertices = $e->getVertices();

        return [
            $eVertices->getVertexFirst(),
            $eVertices->getVertexLast(),
        ];
    }

    /**
     * Gets an array of the corresponding vertices in $g using $v1 and $v2's ID's.
     *
     * @param Graph $g
     * @param Vertex $v1
     * @param Vertex $v2
     *
     * @return array
     */
    private function getVerticesFrom(Graph $g, Vertex $v1, Vertex $v2): array
    {
        return [
            $g->getVertex($v1->getId()),
            $g->getVertex($v2->getId()),
        ];
    }
}