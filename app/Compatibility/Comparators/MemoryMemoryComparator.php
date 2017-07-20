<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\MemoryComponent;

class MemoryMemoryComparator implements IncompatibilityComparator
{
    // memory0
    public $select0 = [
        'id',
    ];

    // memory1
    public $select1 = [
        'id',
    ];

    /**
     * @param MemoryComponent $memory0
     * @param MemoryComponent $memory1
     *
     * @return bool
     */
    public function isIncompatible($memory0, $memory1): bool
    {
        return $memory0->id !== $memory1->id;
    }
}
