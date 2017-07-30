<?php

namespace Tests\Unit;

use Fhaculty\Graph\Graph;
use PCForge\Compatibility\Contracts\ShortestPathsContract;
use Tests\TestCase;

/**
 * https://i.imgur.com/DKUoJgF.jpg
 */
class ShortestPathsTest extends TestCase
{
    /** @var ShortestPathsContract $shortestPaths */
    private $shortestPaths;

    protected function setUp()
    {
        parent::setUp();

        $this->shortestPaths = resolve(ShortestPathsContract::class);
    }

    public function testGetAll()
    {
        $g = new Graph();

        $va = $g->createVertex('a');
        $vb = $g->createVertex('b');
        $vc = $g->createVertex('c');
        $vd = $g->createVertex('d');
        $ve = $g->createVertex('e');
        $vf = $g->createVertex('f');
        $vg = $g->createVertex('g');
        $vh = $g->createVertex('h');
        $vi = $g->createVertex('i');

        // a ->
        $va->createEdge($vd); // d
        $va->createEdge($ve); // e
        $va->createEdge($vi); // i

        // b ->
        $vb->createEdge($ve); // e
        $vb->createEdge($vf); // f

        // c ->
        $vc->createEdge($ve); // e
        $vc->createEdge($vf); // f

        // d ->
        $vd->createEdge($vh); // h

        // e ->
        $ve->createEdge($vg); // g

        // f ->
        $vf->createEdge($vg); // g

        // g ->
        $vg->createEdge($vi); // i

        // a <-> f
        $all = $this->shortestPaths->getAll($va, $vf);

        $this->assertTrue($all->count() === 5, 'Not exactly 5 found');
        $this->assertTrue($all->hasVertexId('b'), 'b not in paths');
        $this->assertTrue($all->hasVertexId('c'), 'c not in paths');
        $this->assertTrue($all->hasVertexId('e'), 'd not in paths');
        $this->assertTrue($all->hasVertexId('g'), 'g not in paths');
        $this->assertTrue($all->hasVertexId('i'), 'i not in paths');
    }
}
