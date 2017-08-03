<?php

namespace PCForge\Compatibility\Helpers;

use Fhaculty\Graph\Edge\Base as Edge;
use Fhaculty\Graph\Graph;
use Fhaculty\Graph\Set\Vertices;
use Fhaculty\Graph\Vertex;
use Illuminate\Support\Collection;
use PCForge\Compatibility\Contracts\ComparatorServiceContract;
use PCForge\Compatibility\Contracts\IncompatibilityGraphContract;
use PCForge\Compatibility\Contracts\ShortestPathsContract;
use PCForge\Models\ComponentChild;

class IncompatibilityGraph implements IncompatibilityGraphContract
{
    /** @var ComparatorServiceContract $comparatorService */
    private $comparatorService;

    /** @var ShortestPathsContract $shortestPaths */
    private $shortestPaths;

    public function __construct(ComparatorServiceContract $comparatorService, ShortestPathsContract $shortestPaths)
    {
        $this->comparatorService = $comparatorService;
        $this->shortestPaths = $shortestPaths;
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
        // TODO: new algo...
        $gC = GraphUtils::complement($g);
        $newEdges = [];
        $typeSums = $this->getTypeSums($g->getVertices());

        // deal with non-edges in $g and test for true compatibility
        /** @var Edge $e */
        foreach ($gC->getEdges() as $e) {
            /**
             * @var Vertex $v1 from $g
             * @var Vertex $v2 from $g
             */
            list($v1, $v2) = $this->getCorrespondingEdgeVertices($g, $e);

            if (!$this->isTrulyCompatible($typeSums, $v1, $v2)) {
                // create incompatibility edge in $g
                $newEdges[] = [$v1, $v2];
            }
        }

        // add new edges to $g
        foreach ($newEdges as list($v1, $v2)) {
            $v1->createEdge($v2);
        }

        return $g;
    }

    /**
     * Gets whether or not the given vertices are truly compatible.
     *
     * @param array $typeSums the result of {@see getTypeSums} given all vertices
     * @param Vertex $v1
     * @param Vertex $v2
     *
     * @return bool
     */
    public function isTrulyCompatible(array $typeSums, Vertex $v1, Vertex $v2): bool
    {
        $v2Class = get_class(GraphUtils::getVertexComponent($v2));
        $typeSums = array_merge([], $typeSums, [
            $v2Class => $typeSums[$v2Class] - 1,
        ]);

        $verticesInPaths = $this->shortestPaths->getAll($v1, $v2);

        if ($verticesInPaths->count() === 0) {
            return true;
        }

        $pathsTypeSums = $this->getTypeSums($verticesInPaths);

        if ($v1->getId() === 'a' && $v2->getId() === 'f') {
            echo '[' . $v1->getId() . ', ' . $v2->getId() . ']' . PHP_EOL;
            echo json_encode($typeSums, JSON_PRETTY_PRINT) . PHP_EOL;
            echo json_encode($pathsTypeSums, JSON_PRETTY_PRINT) . PHP_EOL;
        }

        // get type sums of the shortest paths vertex set
        foreach ($pathsTypeSums as $key => $sum) {
            if ($sum < $typeSums[$key]) {
                return true;
            }
        }

        return false;
    }

    /**
     * Gets a map of component class names to the number of occurrences of that component type in the given vertices
     * set.
     *
     * @param Vertices $vertices
     *
     * @return array
     */
    private function getTypeSums(Vertices $vertices): array
    {
        $arr = [];

        /** @var Vertex $v */
        foreach ($vertices as $v) {
            $key = get_class(GraphUtils::getVertexComponent($v));
            $arr[$key] = ($arr[$key] ?? 0) + 1;
        }

        return $arr;
    }

    /**
     * Creates a vertex with the given $id in $g if it does not yet exist, and sets the component attribute to the given
     * $component.
     *
     * @param Graph $g
     * @param int $id
     * @param ComponentChild $component
     *
     * @return Vertex
     */
    private function createVertex(Graph $g, int $id, ComponentChild $component): Vertex
    {
        $v = $g->createVertex($id, true);

        GraphUtils::setVertexComponent($v, $component);

        return $v;
    }

    /**
     * Gets an array of the corresponding vertices in $g using $e's vertices.
     *
     * @param Graph $g
     * @param Edge $e
     *
     * @return array
     */
    private function getCorrespondingEdgeVertices(Graph $g, Edge $e): array
    {
        $eVertices = $e->getVertices();

        return [
            $g->getVertex($eVertices->getVertexFirst()->getId()),
            $g->getVertex($eVertices->getVertexLast()->getId())
        ];
    }
}