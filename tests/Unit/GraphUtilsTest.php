<?php

namespace Tests\Unit;

use Fhaculty\Graph\Graph;
use PCForge\Compatibility\Helpers\GraphUtils;
use Tests\TestCase;

class GraphUtilsTest extends TestCase
{
    public function testComplement()
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

        $gC = GraphUtils::complement($g);

        $va = $gC->getVertex('a');
        $vb = $gC->getVertex('b');
        $vc = $gC->getVertex('c');
        $vd = $gC->getVertex('d');
        $ve = $gC->getVertex('e');
        $vf = $gC->getVertex('f');
        $vg = $gC->getVertex('g');
        $vh = $gC->getVertex('h');
        $vi = $gC->getVertex('i');

        $this->assertTrue($gC->hasVertex('a'), 'a not in graph');
        $this->assertTrue($gC->hasVertex('b'), 'b not in graph');
        $this->assertTrue($gC->hasVertex('c'), 'c not in graph');
        $this->assertTrue($gC->hasVertex('d'), 'd not in graph');
        $this->assertTrue($gC->hasVertex('e'), 'e not in graph');
        $this->assertTrue($gC->hasVertex('f'), 'f not in graph');
        $this->assertTrue($gC->hasVertex('g'), 'g not in graph');
        $this->assertTrue($gC->hasVertex('h'), 'h not in graph');
        $this->assertTrue($gC->hasVertex('i'), 'i not in graph');

        // a
        $this->assertTrue($va->hasEdgeTo($vb), 'a not adjacent to b');
        $this->assertTrue($va->hasEdgeTo($vc), 'a not adjacent to c');
        $this->assertTrue($va->hasEdgeTo($vf), 'a not adjacent to f');
        $this->assertTrue($va->hasEdgeTo($vg), 'a not adjacent to g');
        $this->assertTrue($va->hasEdgeTo($vh), 'a not adjacent to h');

        $this->assertFalse($va->hasEdgeTo($vd), 'a is adjacent to d');
        $this->assertFalse($va->hasEdgeTo($ve), 'a is adjacent to e');
        $this->assertFalse($va->hasEdgeTo($vi), 'a is adjacent to i');

        // b
        $this->assertTrue($vb->hasEdgeTo($vc), 'b not adjacent to c');
        $this->assertTrue($vb->hasEdgeTo($vd), 'b not adjacent to d');
        $this->assertTrue($vb->hasEdgeTo($vg), 'b not adjacent to g');
        $this->assertTrue($vb->hasEdgeTo($vh), 'b not adjacent to h');
        $this->assertTrue($vb->hasEdgeTo($vi), 'b not adjacent to i');

        $this->assertFalse($vb->hasEdgeTo($ve), 'b is adjacent to e');
        $this->assertFalse($vb->hasEdgeTo($vf), 'b is adjacent to f');

        // c
        $this->assertTrue($vc->hasEdgeTo($vd), 'c not adjacent to d');
        $this->assertTrue($vc->hasEdgeTo($vg), 'c not adjacent to g');
        $this->assertTrue($vc->hasEdgeTo($vh), 'c not adjacent to h');
        $this->assertTrue($vc->hasEdgeTo($vi), 'c not adjacent to i');

        $this->assertFalse($vc->hasEdgeTo($ve), 'c is adjacent to e');
        $this->assertFalse($vc->hasEdgeTo($vf), 'c is adjacent to f');

        // d
        $this->assertTrue($vd->hasEdgeTo($ve), 'd not adjacent to e');
        $this->assertTrue($vd->hasEdgeTo($vf), 'd not adjacent to f');
        $this->assertTrue($vd->hasEdgeTo($vg), 'd not adjacent to g');
        $this->assertTrue($vd->hasEdgeTo($vi), 'd not adjacent to i');

        $this->assertFalse($vd->hasEdgeTo($vh), 'd is adjacent to h');

        // e
        $this->assertTrue($ve->hasEdgeTo($vf), 'e not adjacent to f');
        $this->assertTrue($ve->hasEdgeTo($vh), 'e not adjacent to h');
        $this->assertTrue($ve->hasEdgeTo($vi), 'e not adjacent to i');

        $this->assertFalse($ve->hasEdgeTo($vg), 'e is adjacent to g');

        // f
        $this->assertTrue($vf->hasEdgeTo($vh), 'f not adjacent to h');
        $this->assertTrue($vf->hasEdgeTo($vi), 'f not adjacent to i');

        $this->assertFalse($vf->hasEdgeTo($vg), 'f is adjacent to g');

        // g
        $this->assertTrue($vg->hasEdgeTo($vh), 'g not adjacent to h');

        $this->assertFalse($vg->hasEdgeTo($vi), 'g is adjacent to i');

        // h
        $this->assertTrue($vh->hasEdgeTo($vi), 'h not adjacent to i');
    }
}
