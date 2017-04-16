<?php

namespace PCForge;

class AdjacencyMatrix
{
    /** @var int $n */
    private $n;

    /** @var array $arr */
    private $arr = [];

    /**
     * AdjacencyMatrix constructor.
     *
     * @param array $nodesToAdjacent
     */
    public function __construct(array $nodesToAdjacent)
    {
        $this->n = count($nodesToAdjacent);

        for ($i = 0; $i < $this->n; $i++) {
            for ($j = 0; $j < $this->n; $j++) {
                $this->arr[$i][$j] = $this->arr[$j][$i] = in_array($j, $nodesToAdjacent[$i]) ? 1 : 0;
            }
        }
    }

    /**
     * Removes the given node from the adjacency matrix, effectively zeroing its row and column.
     *
     * @param int $node
     */
    public function removeNode(int $node): void
    {
        for ($j = 0; $j < $this->n; $j++) {
            $this->arr[$node][$j] = $this->arr[$j][$node] = 0;
        }
    }

    /**
     * Gets an array of reachable nodes from the given one.
     *
     * @param int $node
     *
     * @return array
     */
    public function getReachable(int $node): array
    {
        $stack = [$node];
        $reachable = [];

        while (!empty($stack)) {
            $i = array_pop($stack);

            if (!in_array($i, $reachable)) {
                $reachable[] = $i;

                for ($j = 0; $j < $this->n; $j++) {
                    if ($this->haveEdge($i, $j)) {
                        $stack[] = $j;
                    }
                }
            }
        }

        return $reachable;
    }

    /**
     * Gets whether or not the two given nodes have an edge connecting them.
     *
     * @param int $node1
     * @param int $node2
     *
     * @return bool
     */
    public function haveEdge(int $node1, int $node2): bool
    {
        return $this->arr[$node1][$node2] === 1;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->arr;
    }
}
