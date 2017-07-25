<?php

namespace PCForge\Compatibility\Services;

use Exception;
use Fhaculty\Graph\Edge\Base as Edge;
use Fhaculty\Graph\Exception\OutOfBoundsException;
use Fhaculty\Graph\Exception\RuntimeException as FhacultyRuntimeException;
use Fhaculty\Graph\Graph;
use Fhaculty\Graph\Set\Vertices;
use Fhaculty\Graph\Vertex;
use Graphp\Algorithms\ShortestPath\BreadthFirst;
use Graphp\Algorithms\ShortestPath\Dijkstra;
use Graphp\GraphViz\GraphViz;
use Illuminate\Support\Collection;
use PCForge\Compatibility\Comparators\IncompatibilityComparator;
use PCForge\Contracts\ComponentIncompatibilityServiceContract;
use PCForge\Contracts\ComponentRepositoryContract;
use PCForge\Contracts\SelectionContract;
use PCForge\Models\Component;
use PCForge\Models\ComponentChild;
use RuntimeException;

class ComponentIncompatibilityService implements ComponentIncompatibilityServiceContract
{
    private const COMPONENT_ATTR = 'component';

    /** @var ComponentRepositoryContract $componentRepo */
    private $componentRepo;

    /** @var SelectionContract $selection */
    private $selection;

    /** @var array $comparators */
    private $comparators;

    public function __construct(ComponentRepositoryContract $componentRepo, SelectionContract $selection, array $comparators)
    {
        $this->componentRepo = $componentRepo;
        $this->selection = $selection;
        $this->comparators = $comparators;
    }

    public function getIncompatibilities(): Collection
    {
        $this->buildIncompatibilityGraph();

        $this->ddGraph($this->g);

        if (count($this->selection->getAll()) === 0) {
            return collect();
        }

        return $this->selection->getAll()
            ->map(function (ComponentChild $component) {
                return $this->componentToVertexMap[$component->parent->id];
            })
            ->reduce(function ($carry, Vertex $v) {
                /** @var Collection|null $carry */
                return $carry
                    ? $carry->intersect($v->getVerticesEdge()->getVector())
                    : collect($v->getVerticesEdge()->getVector());
            })
            ->map(function (Vertex $v) {
                return $v->getAttribute(self::COMPONENT_ATTR);
            });
    }

    /**
     * Builds the true incompatibility graph, setting {@see $g} when it's done.
     */
    private function buildIncompatibilityGraph(): void
    {
        $this->g = new Graph();
        $gComp = new Graph();
        $components = $this->componentRepo->get(true);

        // create initial incompatibility graph without true compatibilities, along with its complement
        $components->each(function (ComponentChild $component1, int $i) use ($gComp, $components) {
            // create or get vertex for $component1 in $g
            $v1 = $this->g->createVertex($i, true);

            $v1->setAttribute(self::COMPONENT_ATTR, $component1);
            $this->componentToVertexMap[$component1->parent->id] = $v1;

            // create or get vertex for $component1 in $gComp
            try {
                $vComp1 = $gComp->createVertexClone($v1);
            }
            catch (RuntimeException $e) {
                $vComp1 = $gComp->getVertex($i);
            }

            // only compare $component1 to a latter component to maintain O((n^2+n)/2)
            $components->slice($i + 1)->each(function (ComponentChild $component2, int $j) use ($component1, $i, $gComp, $v1, $vComp1) {
                // create or get vertex for $component2 in $g
                $v2 = $this->g->createVertex($j, true);

                $v2->setAttribute(self::COMPONENT_ATTR, $component2);
                $this->componentToVertexMap[$component2->parent->id] = $v2;

                // create or get vertex for $component2 in $gComp
                try {
                    $vComp2 = $gComp->createVertexClone($v2);
                }
                catch (RuntimeException $e) {
                    $vComp2 = $gComp->getVertex($j);
                }

                // put components in correct natural order; the attribute for vertex $v2 should already be set
                list($component1, $component2) = $this->sortComponents($component1, $component2);
                $comparator = $this->getComparator($component1, $component2);

                // create incompatibility edges in $g where components are directly incompatible, else create the edge
                // in $gComp to be tested for true compatibility later; this is nice because we're simultaneously
                // building a graph and its complement
                if ($comparator !== null && $comparator->isIncompatible($component1, $component2)) {
                    $v1->createEdge($v2);
                }
                else {
                    $vComp1->createEdge($vComp2);
                }
            });
        });

        $this->ddGraph($this->g);

        $gTmp = $this->g->createGraphClone();
        $typeSums = [];

        // get master type sums array
        $this->setTypeSums($typeSums, $gTmp->getVertices());

        // deal with non-edges in $g and test for true compatibility
        /** @var Edge $e */
        foreach ($gComp->getEdges() as $e) {
            $vertices = $e->getVertices();
            $v1 = $gTmp->getVertex($vertices->getVertexFirst()->getId());
            $v2 = $gTmp->getVertex($vertices->getVertexLast()->getId());

            if (!$this->areTrulyCompatible($typeSums, $v1, $v2)) {
                // create corresponding incompatibility edge in $g
                $this->g->getVertex($v1->getId())->createEdge($this->g->getVertex($v2->getId()));
            }
        }
    }

    /**
     * Gets whether or not the given vertices are truly compatible.
     *
     * @param array $typeSums the result of {@see setTypeSums} given all vertices
     * @param Vertex $v1
     * @param Vertex $v2
     *
     * @return bool
     */
    private function areTrulyCompatible(array $typeSums, Vertex $v1, Vertex $v2): bool
    {
        // TODO: fix dis shit
        $algo = new BreadthFirst($v1);

        if (!$algo->hasVertex($v2)) {
            return true;
        }

        try {
            // union of all shortest path vertices from $v1 to $v2, excluding endpoints
            $pathsVertices = $algo
                ->getVertices()
                ->getVerticesMatch(function (Vertex $v) use ($v1, $v2) {
                    $id = $v->getId();

                    // filter out endpoint vertices
                    return $id !== $v1->getId() && $id !== $v2->getId();
                })
                ->getVerticesDistinct();
        }
        catch (OutOfBoundsException $e) {
            return true;
        }

        $pathsTypeSums = [];

        // get type sums of the shortest paths vertex set
        $this->setTypeSums($pathsTypeSums, $pathsVertices);

        foreach ($pathsTypeSums as $key => $sum) {
            // if $key doesn't exist in $typeSums, we're in trouble
            if ($sum < $typeSums[$key]) {
                return true;
            }
        }

        return false;
    }

    /**
     * Gets the (unordered) set of vertices that lie on any shortest path from $v1 to $v2, excluding $v1 and $v2.
     *
     * @param Vertex $v1
     * @param Vertex $v2
     *
     * @return Vertices
     */
    private function getAllShortestPaths(Vertex $v1, Vertex $v2): Vertices
    {
        if ($v1->getGraph() !== $v2->getGraph()) {
            throw new RuntimeException('Vertices $v1 and $v2 are not in the same graph');
        }

        // adjacent vertices are the sole shortest path, but we exclude $v1 and $v2 from the return set, so...
        if ($v1->hasEdgeTo($v2)) {
            return new Vertices();
        }

        $g = new Graph();
        $stack = [$v1];
        $foundV2 = false;

        while (!empty($stack)) {
            /** @var Vertex $current */
            $current = array_pop($stack);
            $currentInG = $g->hasVertex($current->getId())
                ? $g->getVertex($current->getId())
                : $g->createVertexClone($current);

            /** @var Vertex $adjacent */
            foreach ($current->getVerticesEdge() as $adjacent) {
                $adjacentInG = $g->hasVertex($adjacent->getId())
                    ? $g->getVertex($adjacent->getId())
                    : $g->createVertexClone($adjacent);

                if (!$currentInG->hasEdgeTo($adjacentInG)) {
                    if ($current === $v2) {
                        $foundV2 = true;
                    }
                    else {
                        $stack[] = $adjacent;
                    }

                    $adjacentInG->createEdgeTo($currentInG);
                }
            }
        }

        // if true, there appears to be no path from $v1 to $v2
        if (!$foundV2) {
            return new Vertices();
        }

        $origG = $v1->getGraph();
        $vertices = [$g->getVertex($v2->getId())];

        $this->pushOutwardVertices($vertices);

        // map our imaginary graph vertices to the vertices in the original graph of interest
        $vertices = array_map(function (Vertex $v) use ($origG) {
            return $origG->getVertex($v->getId());
        }, $vertices);

        // exclude $v1 and $v2 from the return set
        $vertices = array_filter($vertices, function (Vertex $v) use ($v1, $v2) {
            return $v !== $v1 && $v !== $v2;
        });

        // extensionality of sets
        return (new Vertices($vertices))->getVerticesDistinct();
    }

    /**
     * Recursively pushes vertices that flow outward from an initial $vertices array to that array.
     *
     * @param array $vertices
     * @param array $newVertices should be empty in the initial method call
     */
    private function pushOutwardVertices(array &$vertices, array $newVertices = []): void
    {
        /** @var Vertex $v */
        foreach ($newVertices as $v) {
            $adjacentVertices = $v->getVerticesEdgeTo()->getVector();

            if (count($adjacentVertices) > 0) {
                array_push($vertices, ...$adjacentVertices);
                $this->pushOutwardVertices($vertices, $adjacentVertices);
            }
        }
    }

    /**
     * Sets the given array to a map of component class names to the number of occurrences of that component type in the
     * given vertices set.
     *
     * @param array $arr
     * @param Vertices $vertices
     */
    private function setTypeSums(array &$arr, Vertices $vertices): void
    {
        $arr = [];

        /** @var Vertex $v */
        foreach ($vertices as $v) {
            $key = get_class($v->getAttribute(self::COMPONENT_ATTR));
            $arr[$key] = ($arr[$key] ?? 0) + 1;
        }
    }

    /**
     * Returns the given components in an array, sorted by the natural order of their class names.
     *
     * @param ComponentChild $component1
     * @param ComponentChild $component2
     *
     * @return array
     */
    private function sortComponents(ComponentChild $component1, ComponentChild $component2): array
    {
        if (get_class($component1) === get_class($component2)) {
            return [$component1, $component2];
        }

        $components = [
            get_class($component1) => $component1,
            get_class($component2) => $component2,
        ];

        ksort($components);

        return array_values($components);
    }

    /**
     * Gets the comparator that can compare the two given components. If none exists, then null is returned. The two
     * components should be provided in the natural order of their class names.
     *
     * @param ComponentChild $component1
     * @param ComponentChild $component2
     *
     * @return IncompatibilityComparator|null
     */
    private function getComparator(ComponentChild $component1, ComponentChild $component2): ?IncompatibilityComparator
    {
        $class = '\PCForge\Compatibility\Comparators\\'
            . $this->componentToType($component1, false)
            . $this->componentToType($component2, false)
            . 'Comparator';

        return class_exists($class) ? resolve($class) : null;
    }

    /**
     * Converts a component to its type. E.g. 'ChassisComponent' becomes 'chassis'.
     *
     * @param ComponentChild $component
     * @param bool $lcfirst whether the first character should be converted to lowercase
     *
     * @return string
     */
    private function componentToType(ComponentChild $component, bool $lcfirst = true): string
    {

        $str = substr(class_basename(get_class($component)), 0, -strlen('Component'));

        return $lcfirst ? lcfirst($str) : $str;
    }

    /**
     * Echos an image representation of the given graph and dies. May only be used when 'app.debug' is true.
     *
     * @param Graph $g
     *
     * @throws Exception
     */
    private function ddGraph(Graph $g): void
    {
        if (!config('app.debug')) {
            throw new Exception('Debugging is disabled');
        }

        /** @var Vertex $v */
        foreach ($g->getVertices() as $v) {
            $name = Component::findOrFail($v->getId() + 1)->name;

            $v->setAttribute('graphviz.label', $name);
        }

        echo (new GraphViz())->createImageHtml($g);
        dd();
    }
}
