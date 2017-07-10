<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\ChassisComponent;
use PCForge\Models\CoolingComponent;
use PCForge\Models\GraphicsComponent;
use PCForge\Models\MemoryComponent;
use PCForge\Models\MotherboardComponent;
use PCForge\Models\ProcessorComponent;

class MemoryMotherboardComparator implements IncompatibilityComparator
{
    // memory
    public $select0 = [
        'ddr_gen',
        'pins',
    ];

    // motherboard
    public $select1 = [
        'dimm_gen',
        'dimm_pins',
    ];

    /**
     * @param MemoryComponent $memory
     * @param MotherboardComponent $motherboard
     *
     * @return bool
     */
    public function isIncompatible($memory, $motherboard): bool
    {
        // TODO: dynamic incompatibilities
        return $memory->ddr_gen !== $motherboard->dimm_gen
            || $memory->pins !== $motherboard->dimm_pins;
    }
}
