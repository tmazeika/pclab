<?php

namespace PCForge\Compatibility\Comparators;


use PCForge\Models\MemoryComponent;
use PCForge\Models\MotherboardComponent;

class MemoryMotherboardComparator implements IncompatibilityComparator
{
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
}