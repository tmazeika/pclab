<?php

namespace PCForge;

use Iterator;

class AdjacencyMatrix implements Iterator
{
    /** @var int $in */
    private $n;

    /** @var int[] $nodes */
    private $nodes = [];

    /** @var array $arr */
    private $arr = [];

    /**
     * Constructs an AdjacencyMatrix for the given edges.
     *
     * @param array $nodesToAdjacent an associative array of nodes to an array of their adjacent nodes, all as integers
     */
    public function __construct(array $nodesToAdjacent)
    {
        $this->n = count($nodesToAdjacent);
        $this->nodes = array_keys($nodesToAdjacent);

        for ($i = 0; $i < $this->n; $i++) {
            for ($j = 0; $j < $this->n; $j++) {
                $this->arr[$i][$j] = $this->arr[$j][$i] = in_array($j, $nodesToAdjacent[$i], true) ? 1 : 0;
            }
        }
    }

    /**
     * Sets the given node's row and column in the adjacency matrix to 0, effectively removing all edges that node may
     * have with others.
     *
     * @param int $node the node whose column and row are to be zeroed
     */
    public function zeroNode(int $node): void
    {
        foreach ($this->nodes as $row) {
            $this->arr[$node][$row] = $this->arr[$row][$node] = 0;
        }
    }

    /**
     * Gets an array of nodes that are reachable through adjacency from the given node.
     *
     * @param int $node the node from which to start
     *
     * @return int[] reachable nodes
     */
    public function getAllReachableNodesFrom(int $node): array
    {
        $stack = [$node];
        $reachableNodes = [];

        while (!empty($stack)) {
            $i = array_pop($stack);

            // check that this node hasn't already been reached
            if (!in_array($i, $reachableNodes, true)) {
                for ($j = 0; $j < $this->n; $j++) {
                    // if this row has an edge with this column...
                    if ($this->arr[$i][$j] === 1) {
                        // check that this node hasn't already been added once
                        if (!in_array($i, $reachableNodes, true)) {
                            $reachableNodes[] = $i;
                        }

                        $stack[] = $j;
                    }
                }
            }
        }

        return $reachableNodes;
    }

    /**
     * @param int $i the column
     * @param int $j the row
     *
     * @return bool whether there is an edge at the intersection between $i and $j
     */
    public function hasEdgeAt(int $i, int $j): bool
    {
        return $this->arr[$i][$j] === 1;
    }

    /**
     * @return int the number of nodes in this adjacency matrix
     */
    public function getN(): int
    {
        return $this->n;
    }

    /**
     * Gets the adjacency matrix in its 2D array form.
     *
     * @return int[][] an n by n adjacency matrix, where n is the number of nodes
     */
    public function toArray(): array
    {
        return $this->arr;
    }

    /**
     * Stringify the adjacency matrix.
     *
     * @return string
     */
    function __toString(): string
    {
        $str = '   ';

        for ($i = 0; $i < $this->n; $i++) {
            $str .= $i + 1 . ' ';
        }

        $str .= PHP_EOL;

        for ($j = 0; $j < $this->n; $j++) {
            $str .= $j + 1 . ' ';

            if ($j < 9) {
                $str .= ' ';
            }

            for ($i = 0; $i < $this->n; $i++) {
                $str .= $this->arr[$i][$j] . ' ';

                if ($i > 8) {
                    $str .= ' ';
                }
            }

            $str .= PHP_EOL;
        }

        return $str;
    }

    public function current()
    {
        return current($this->nodes);
    }

    public function next()
    {
        next($this->nodes);
    }

    public function key()
    {
        return key($this->nodes);
    }

    public function valid()
    {
        $key = key($this->nodes);

        return $key !== null && $key !== false;
    }

    public function rewind()
    {
        reset($this->nodes);
}}
