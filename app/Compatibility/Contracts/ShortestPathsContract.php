<?php

namespace PCForge\Compatibility\Contracts;

use Fhaculty\Graph\Set\Vertices;
use Fhaculty\Graph\Vertex;

interface ShortestPathsContract
{
    /**
     * Gets the (unordered) set of vertices that lie on any shortest path from $v1 to $v2, excluding $v1 and $v2.
     *
     * @param Vertex $v1
     * @param Vertex $v2
     *
     * @return Vertices
     */
    public function getAll(Vertex $v1, Vertex $v2): Vertices;
}