<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\MemoryComponent;
use PCForge\Models\MotherboardComponent;

class MemoryMotherboardComparator implements IncompatibilityComparator
{
    // memory
    public $select1 = [
        'ddr_gen',
        'pins',
    ];

    // motherboard
    public $select2 = [
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
        return $memory->ddr_gen !== $motherboard->dimm_gen
            || $memory->pins !== $motherboard->dimm_pins;
    }

    public function getComponents(): array
    {
        return ['memory', 'motherboard'];
    }
}
