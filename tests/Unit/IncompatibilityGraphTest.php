<?php

namespace Tests\Unit;

use Fhaculty\Graph\Graph;
use PCForge\Compatibility\Helpers\IncompatibilityGraph;
use PCForge\Models\ChassisComponent;
use PCForge\Models\CoolingComponent;
use PCForge\Models\GraphicsComponent;
use PCForge\Models\MotherboardComponent;
use PCForge\Models\ProcessorComponent;
use Tests\TestCase;

class IncompatibilityGraphTest extends TestCase
{
    public function testBuildTrue()
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

        $va->setAttribute('component', new ChassisComponent);
        $vb->setAttribute('component', new MotherboardComponent);
        $vc->setAttribute('component', new ProcessorComponent);
        $vd->setAttribute('component', new ChassisComponent);
        $ve->setAttribute('component', new MotherboardComponent);
        $vf->setAttribute('component', new ProcessorComponent);
        $vg->setAttribute('component', new CoolingComponent);
        $vh->setAttribute('component', new GraphicsComponent);
        $vi->setAttribute('component', new CoolingComponent);

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

        resolve(IncompatibilityGraph::class)->buildTrue($g);

        $this->assertTrue($g->hasVertex('a'), 'a not in graph');
        $this->assertTrue($g->hasVertex('b'), 'b not in graph');
        $this->assertTrue($g->hasVertex('c'), 'c not in graph');
        $this->assertTrue($g->hasVertex('d'), 'd not in graph');
        $this->assertTrue($g->hasVertex('e'), 'e not in graph');
        $this->assertTrue($g->hasVertex('f'), 'f not in graph');
        $this->assertTrue($g->hasVertex('g'), 'g not in graph');
        $this->assertTrue($g->hasVertex('h'), 'h not in graph');
        $this->assertTrue($g->hasVertex('i'), 'i not in graph');

        // a
        $this->assertTrue($va->hasEdgeTo($vd), 'a not adjacent to d');
        $this->assertTrue($va->hasEdgeTo($ve), 'a not adjacent to e');
        $this->assertTrue($va->hasEdgeTo($vf), 'a not adjacent to f');
        $this->assertTrue($va->hasEdgeTo($vi), 'a not adjacent to i');

        $this->assertFalse($va->hasEdgeTo($vb), 'a is adjacent to b');
        $this->assertFalse($va->hasEdgeTo($vc), 'a is adjacent to c');
        $this->assertFalse($va->hasEdgeTo($vg), 'a is adjacent to g');
        $this->assertFalse($va->hasEdgeTo($vh), 'a is adjacent to h');

        // b
        $this->assertTrue($vb->hasEdgeTo($ve), 'b not adjacent to e');
        $this->assertTrue($vb->hasEdgeTo($vf), 'b not adjacent to f');

        $this->assertFalse($vb->hasEdgeTo($vc), 'b is adjacent to c');
        $this->assertFalse($vb->hasEdgeTo($vd), 'b is adjacent to d');
        $this->assertFalse($vb->hasEdgeTo($vg), 'b is adjacent to g');
        $this->assertFalse($vb->hasEdgeTo($vh), 'b is adjacent to h');
        $this->assertFalse($vb->hasEdgeTo($vi), 'b is adjacent to i');

        // c
        $this->assertTrue($vc->hasEdgeTo($ve), 'c not adjacent to e');
        $this->assertTrue($vc->hasEdgeTo($vf), 'c not adjacent to f');

        $this->assertFalse($vc->hasEdgeTo($vd), 'c is adjacent to d');
        $this->assertFalse($vc->hasEdgeTo($vg), 'c is adjacent to g');
        $this->assertFalse($vc->hasEdgeTo($vh), 'c is adjacent to h');
        $this->assertFalse($vc->hasEdgeTo($vi), 'c is adjacent to i');

        // d
        $this->assertTrue($vd->hasEdgeTo($vh), 'd not adjacent to h');

        $this->assertFalse($vd->hasEdgeTo($ve), 'd is adjacent to e');
        $this->assertFalse($vd->hasEdgeTo($vf), 'd is adjacent to f');
        $this->assertFalse($vd->hasEdgeTo($vg), 'd is adjacent to g');
        $this->assertFalse($vd->hasEdgeTo($vi), 'd is adjacent to i');

        // e
        $this->assertTrue($ve->hasEdgeTo($vg), 'e not adjacent to g');
        $this->assertTrue($ve->hasEdgeTo($vh), 'e not adjacent to h');

        $this->assertFalse($ve->hasEdgeTo($vf), 'e is adjacent to f');
        $this->assertFalse($ve->hasEdgeTo($vi), 'e is adjacent to i');

        // f
        $this->assertTrue($vf->hasEdgeTo($vg), 'f not adjacent to g');
        $this->assertTrue($vf->hasEdgeTo($vh), 'f not adjacent to h');

        $this->assertFalse($vf->hasEdgeTo($vi), 'f is adjacent to i');

        // g
        $this->assertTrue($vg->hasEdgeTo($vi), 'g not adjacent to i');

        $this->assertFalse($vg->hasEdgeTo($vh), 'g is adjacent to h');
    }
}
