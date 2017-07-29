<?php

namespace PCForge\Compatibility\Helpers;

use Fhaculty\Graph\Edge\Base as Edge;
use Fhaculty\Graph\Graph;
use Fhaculty\Graph\Set\Vertices;
use Fhaculty\Graph\Vertex;
use PCForge\Compatibility\Contracts\ComparatorServiceContract;
use PCForge\Compatibility\Contracts\ComponentRepositoryContract;
use PCForge\Compatibility\Contracts\IncompatibilityGraphContract;
use PCForge\Compatibility\Contracts\ShortestPathsContract;
use PCForge\Models\ComponentChild;

class IncompatibilityGraph implements IncompatibilityGraphContract
{
    public const COMPONENT_ATTR = 'component';

    /** @var ComponentRepositoryContract $componentRepo */
    private $componentRepo;

    /** @var ComparatorServiceContract $comparatorService */
    private $comparatorService;

    /** @var ShortestPathsContract $shortestPaths */
    private $shortestPaths;

    public function __construct(ComponentRepositoryContract $componentRepo,
                                ComparatorServiceContract $comparatorService,
                                ShortestPathsContract $shortestPaths)
    {
        $this->componentRepo = $componentRepo;
        $this->comparatorService = $comparatorService;
        $this->shortestPaths = $shortestPaths;
    }

    public function build(Graph $g): void
    {
        $this->buildBase($g);
    }

    /**
     * Builds the initial and incomplete incompatibility graph.
     *
     * @param Graph $g
     */
    private function buildBase(Graph $g): void
    {
        // soon to be the complement of $g
        $gC = new Graph();
        $components = $this->componentRepo->get();

        $components->each(function (ComponentChild $c1, int $i) use ($g, $gC, $components) {
            $c1Id = $c1->parent->id;
            $v1 = $this->createVertex($g, $c1Id, $c1);
            $v1C = $this->createVertex($gC, $c1Id, $c1);

            $components->slice($i + 1)->each(function (ComponentChild $c2) use ($c1, $v1, $v1C, $g, $gC) {
                $c2Id = $c2->parent->id;
                $v2 = $this->createVertex($g, $c2Id, $c2);
                $v2C = $this->createVertex($gC, $c2Id, $c2);

                // sort $c1 and $c2 by class name
                list($c1, $c2) = array_sort([$c1, $c2], function ($component) {
                    return get_class($component);
                });

                $comparator = $this->comparatorService->get($c1, $c2);

                // create incompatibility edges in $g where components are directly incompatible, else create the edge
                // in $gC to be tested for true compatibility later; this is nice because we're simultaneously building
                // a graph and its complement
                if ($comparator !== null && $comparator->isIncompatible($c1, $c2)) {
                    $v1->createEdge($v2);
                }
                else {
                    $v1C->createEdge($v2C);
                }
            });
        });

        $this->buildTrue($g, $gC);
    }

    /**
     * Builds the true and final incompatibility graph.
     *
     * @param Graph $g
     * @param Graph $gC a complement graph
     */
    private function buildTrue(Graph $g, Graph $gC): void
    {
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
                $v1->createEdge($v2);
            }
        }
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
    private function isTrulyCompatible(array $typeSums, Vertex $v1, Vertex $v2): bool
    {
        $verticesInPaths = $this->shortestPaths->getAll($v1, $v2);

        $pathsTypeSums = $this->getTypeSums($verticesInPaths);

        // get type sums of the shortest paths vertex set
        foreach ($pathsTypeSums as $key => $sum) {
            // if $key doesn't exist in $typeSums, we're in trouble
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
            $key = spl_object_hash($v->getAttribute(self::COMPONENT_ATTR));
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

        $v->setAttribute(self::COMPONENT_ATTR, $component);

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