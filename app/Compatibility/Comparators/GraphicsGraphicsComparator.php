<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\ChassisComponent;
use PCForge\Models\CoolingComponent;
use PCForge\Models\GraphicsComponent;
use PCForge\Models\MemoryComponent;
use PCForge\Models\MotherboardComponent;
use PCForge\Models\ProcessorComponent;

class GraphicsGraphicsComparator implements IncompatibilityComparator
{
    // graphics0
    public $select0 = [
        'id',
    ];

    // graphics1
    public $select1 = [
        'id',
    ];

    /**
     * @param GraphicsComponent $graphics0
     * @param GraphicsComponent $graphics1
     *
     * @return bool
     */
    public function isIncompatible($graphics0, $graphics1): bool
    {
        // TODO: dynamic incompatibilities (PCI-E slots)
        return $graphics0->id === $graphics1->id;
    }
}
