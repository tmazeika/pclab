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

        $g = new Graph();
        $queue = [$v1];
        $v2Found = false;

        while (!empty($queue)) {
            /** @var Vertex $current */
            $current = array_shift($queue);
            $currentInG = $g->createVertex($current->getId(), true);

            // set $v1's level to 0 (in $g, though, since we don't want to mess with the original graph)
            if ($current === $v1) {
                $currentInG->setAttribute('level', 0);
            }
            else if ($current === $v2) {
                $v2Found = true;
                break;
            }

            // 'level' better be set or we're in trouble
            $currentLevel = $currentInG->getAttribute('level');

            /** @var Vertex $adjacent */
            foreach ($current->getVerticesEdge() as $adjacent) {
                $adjacentInG = $g->createVertex($adjacent->getId(), true);
                $adjacentLevel = $adjacentInG->getAttribute('level', -1);

                // vertex is unvisited...
                if ($adjacentLevel === -1) {
                    // let's visit it
                    $adjacentInG->setAttribute('level', $currentLevel + 1);

                    $queue[] = $adjacent;
                    $currentInG->createEdgeTo($adjacentInG);
                }
                // vertex is visited, but it's on the level of interest
                else if ($adjacentLevel === $currentLevel + 1) {
                    $currentInG->createEdgeTo($adjacentInG);
                }
            }
        }

        // if true, there appears to be no path from $v1 to $v2
        if (!$v2Found) {
            return new Vertices();
        }

        $origG = $v1->getGraph();
        $vertices = [];

        $this->followAgainstFlow($g->getVertex($v2->getId()), $vertices);

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
     * @param array $result
     */
    private function followAgainstFlow(Vertex $v1, array &$result = []): void
    {
        // TODO: maybe return an array instead of taking an array pointer?

        $first = false;

        if (count($result) === 0) {
            $first = true;
        }

        /** @var Vertex $v */
        foreach ($v1->getVerticesEdgeFrom() as $v) {
            // else it's an endpoint node, which we don't include
            if ($v->getVerticesEdgeFrom()->count() > 0) {
                array_push($result, $v);

                $this->followAgainstFlow($v, $result);
            }
        }

        if ($first) {
            $result = array_unique($result, SORT_REGULAR);
        }
    }
}