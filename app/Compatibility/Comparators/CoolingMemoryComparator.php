<?php

namespace PCForge\Compatibility\Comparators;


use PCForge\Models\CoolingComponent;
use PCForge\Models\MemoryComponent;

class CoolingMemoryComparator implements IncompatibilityComparator
{
    /**
     * @param CoolingComponent $cooling
     * @param MemoryComponent $memory
     *
     * @return bool
     */
    public function isIncompatible($cooling, $memory): bool
    {
        return $memory->height > $cooling->max_memory_height;
    }

    public function getComponents(): array
    {
        return ['cooling', 'memory'];
    }
}
