<?php

namespace PCLab\Compatibility\Comparators;


use PCLab\Models\CoolingComponent;
use PCLab\Models\MemoryComponent;

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
}