<?php

namespace Tests\Unit;

use Fhaculty\Graph\Graph;
use Illuminate\Support\Collection;
use PCLab\Compatibility\Helpers\IncompatibilityGraph;
use PCLab\Compatibility\Repositories\ComponentRepository;
use PCLab\Models\ChassisComponent;
use PCLab\Models\Component;
use PCLab\Models\ComponentType;
use PCLab\Models\CoolingComponent;
use PCLab\Models\GraphicsComponent;
use PCLab\Models\MotherboardComponent;
use PCLab\Models\ProcessorComponent;
use Tests\TestCase;

class IncompatibilityGraphTest extends TestCase
{
    public function testBuildTrue()
    {
        $g = new Graph();

        $va = $g->createVertex(1);
        $vb = $g->createVertex(2);
        $vc = $g->createVertex(3);
        $vd = $g->createVertex(4);
        $ve = $g->createVertex(5);
        $vf = $g->createVertex(6);
        $vg = $g->createVertex(7);
        $vh = $g->createVertex(8);
        $vi = $g->createVertex(9);

        $vaC = new ChassisComponent;
        $vbC = new MotherboardComponent;
        $vcC = new ProcessorComponent;
        $vdC = new ChassisComponent;
        $veC = new MotherboardComponent;
        $vfC = new ProcessorComponent;
        $vgC = new CoolingComponent;
        $vhC = new GraphicsComponent;
        $viC = new CoolingComponent;

        $vcC->has_apu = true;
        $vcC->has_stock_cooler = false;

        $vfC->has_apu = false;
        $vfC->has_stock_cooler = true;

        $vaCP = $vaC->parent = new Component;
        $vbCP = $vbC->parent = new Component;
        $vcCP = $vcC->parent = new Component;
        $vdCP = $vdC->parent = new Component;
        $veCP = $veC->parent = new Component;
        $vfCP = $vfC->parent = new Component;
        $vgCP = $vgC->parent = new Component;
        $vhCP = $vhC->parent = new Component;
        $viCP = $viC->parent = new Component;

        $vaCP->id = 1;
        $vbCP->id = 2;
        $vcCP->id = 3;
        $vdCP->id = 4;
        $veCP->id = 5;
        $vfCP->id = 6;
        $vgCP->id = 7;
        $vhCP->id = 8;
        $viCP->id = 9;

        $vaCPT = $vaCP->type = new ComponentType;
        $vbCPT = $vbCP->type = new ComponentType;
        $vcCPT = $vcCP->type = new ComponentType;
        $vdCPT = $vdCP->type = new ComponentType;
        $veCPT = $veCP->type = new ComponentType;
        $vfCPT = $vfCP->type = new ComponentType;
        $vgCPT = $vgCP->type = new ComponentType;
        $vhCPT = $vhCP->type = new ComponentType;
        $viCPT = $viCP->type = new ComponentType;

        $vaCPT->name = 'chassis';
        $vaCPT->is_always_required = true;

        $vbCPT->name = 'motherboard';
        $vbCPT->is_always_required = true;

        $vcCPT->name = 'processor';
        $vcCPT->is_always_required = true;

        $vdCPT->name = 'chassis';
        $vdCPT->is_always_required = true;

        $veCPT->name = 'motherboard';
        $veCPT->is_always_required = true;

        $vfCPT->name = 'processor';
        $vfCPT->is_always_required = true;

        $vgCPT->name = 'cooling';
        $vgCPT->is_always_required = false;

        $vhCPT->name = 'graphics';
        $vhCPT->is_always_required = false;

        $viCPT->name = 'cooling';
        $viCPT->is_always_required = false;

        $va->setAttribute('component', $vaC);
        $vb->setAttribute('component', $vbC);
        $vc->setAttribute('component', $vcC);
        $vd->setAttribute('component', $vdC);
        $ve->setAttribute('component', $veC);
        $vf->setAttribute('component', $vfC);
        $vg->setAttribute('component', $vgC);
        $vh->setAttribute('component', $vhC);
        $vi->setAttribute('component', $viC);

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

        $componentRepo = new ComponentRepositoryTest();

        $componentRepo->components = collect([
            $vaC,
            $vbC,
            $vcC,
            $vdC,
            $veC,
            $vfC,
            $vgC,
            $vhC,
            $viC,
        ]);

        app()->makeWith(IncompatibilityGraph::class, ['componentRepo' => $componentRepo])->buildTrue($g);

        $this->assertTrue($g->hasVertex(1), 'a not in graph');
        $this->assertTrue($g->hasVertex(2), 'b not in graph');
        $this->assertTrue($g->hasVertex(3), 'c not in graph');
        $this->assertTrue($g->hasVertex(4), 'd not in graph');
        $this->assertTrue($g->hasVertex(5), 'e not in graph');
        $this->assertTrue($g->hasVertex(6), 'f not in graph');
        $this->assertTrue($g->hasVertex(7), 'g not in graph');
        $this->assertTrue($g->hasVertex(8), 'h not in graph');
        $this->assertTrue($g->hasVertex(9), 'i not in graph');

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
        $this->assertTrue($vd->hasEdgeTo($ve), 'd not adjacent to e');
        $this->assertTrue($vd->hasEdgeTo($vh), 'd not adjacent to h');

        $this->assertFalse($vd->hasEdgeTo($vf), 'd is adjacent to f');
        $this->assertFalse($vd->hasEdgeTo($vg), 'd is adjacent to g');
        $this->assertFalse($vd->hasEdgeTo($vi), 'd is adjacent to i');

        // e
        $this->assertTrue($ve->hasEdgeTo($vg), 'e not adjacent to g');
        $this->assertTrue($ve->hasEdgeTo($vh), 'e not adjacent to h');
        $this->assertTrue($ve->hasEdgeTo($vi), 'e not adjacent to i');

        $this->assertFalse($ve->hasEdgeTo($vf), 'e is adjacent to f');

        // f
        $this->assertTrue($vf->hasEdgeTo($vg), 'f not adjacent to g');
        $this->assertTrue($vf->hasEdgeTo($vh), 'f not adjacent to h');

        $this->assertFalse($vf->hasEdgeTo($vi), 'f is adjacent to i');

        // g
        $this->assertTrue($vg->hasEdgeTo($vi), 'g not adjacent to i');

        $this->assertFalse($vg->hasEdgeTo($vh), 'g is adjacent to h');
    }
}

class ComponentRepositoryTest extends ComponentRepository
{
    public $components;

    public function get(): Collection
    {
        return $this->components;
    }
}