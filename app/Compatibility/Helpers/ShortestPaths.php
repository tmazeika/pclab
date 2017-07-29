<?php

namespace PCForge\Compatibility\Helpers;

use Fhaculty\Graph\Graph;
use Fhaculty\Graph\Set\Vertices;
use Fhaculty\Graph\Vertex;
use PCForge\Compatibility\Contracts\ShortestPathsContract;
use RuntimeException;

class ShortestPaths implements ShortestPathsContract
{
    public function getAll(Vertex $v1, Vertex $v2): Vertices
    {
        if ($v1->getGraph() !== $v2->getGraph()) {
            throw new RuntimeException('Vertices $v1 and $v2 are not in the same graph');
        }

        // adjacent vertices are the sole shortest path, but we exclude $v1 and $v2 from the return set, so...
        if ($v1->hasEdgeTo($v2)) {
            return new Vertices();
        }

        //GraphUtils::dd($v1->getGraph());

        $g = new Graph();
        $queue = [$v1];
        $v2Found = false;

        while (!empty($queue)) {
            /** @var Vertex $current */
            $current = array_shift($queue);
            $currentInG = $g->createVertex($current->getId(), true);
            $currentDist = $currentInG->getAttribute('dist', 0);

            if ($current === $v2) {
                $v2Found = true;
                break;
            }

            /** @var Vertex $adjacent */
            foreach ($current->getVerticesEdge() as $adjacent) {
                $adjacentInG = $g->createVertex($adjacent->getId(), true);
                $adjacentDist = $adjacentInG->getAttribute('dist', -1);

                if ($adjacentDist === -1 && $adjacent !== $v1) {
                    $adjacentInG->setAttribute('dist', $currentDist + 1);
                    $currentInG->createEdgeTo($adjacentInG);

                    $queue[] = $adjacent;
                }
                else if ($currentDist === $adjacentDist) {
                    $currentInG->createEdgeTo($adjacentInG);
                }
            }
        }

        // if true, there appears to be no path from $v1 to $v2
        if (!$v2Found) {
            return new Vertices();
        }

        //dump($v1->getAttribute(IncompatibilityGraph::COMPONENT_ATTR)->parent->name, $v2->getAttribute(IncompatibilityGraph::COMPONENT_ATTR)->parent->name);
        //GraphUtils::dd($g);

        $origG = $v1->getGraph();
        $vertices = $this->followAgainstFlow($g->getVertex($v2->getId()));

        // map our imaginary graph vertices to the vertices in the original graph of interest
        $vertices = array_map(function (Vertex $v) use ($origG) {
            return $origG->getVertex($v->getId());
        }, $vertices);

        return new Vertices($vertices);
    }

    /**
     * Recursively finds all vertices that flow in towards the given vertex.
     *
     * @param Vertex $v1
     *
     * @return array
     */
    private function followAgainstFlow(Vertex $v1): array
    {
        $result = [];

        foreach ($v1->getVerticesEdgeFrom() as $v) {
            $result += [$v] + $this->followAgainstFlow($v);
        }

        return array_unique($result);
    }
}