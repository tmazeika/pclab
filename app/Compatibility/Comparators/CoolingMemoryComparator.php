<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\CoolingComponent;
use PCForge\Models\MemoryComponent;

class CoolingMemoryComparator implements IncompatibilityComparator
{
    // cooling
    public $select1 = [
        'max_memory_height',
    ];

    // memory
    public $select2 = [
        'height',
    ];

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
}
