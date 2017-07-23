<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\MemoryComponent;

class MemoryMemoryComparator implements IncompatibilityComparator
{
    // memory 1
    public $select1 = [
        'id',
    ];

    // memory 2
    public $select2 = [
        'id',
    ];

    /**
     * @param MemoryComponent $memory1
     * @param MemoryComponent $memory2
     *
     * @return bool
     */
    public function isIncompatible($memory1, $memory2): bool
    {
        return $memory1->id !== $memory2->id;
    }

    public function getComponents(): array
    {
        return ['memory', 'memory'];
    }
}
