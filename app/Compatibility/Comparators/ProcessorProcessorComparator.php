<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\MotherboardComponent;
use PCForge\Models\PowerComponent;
use PCForge\Models\ProcessorComponent;

class ProcessorProcessorComparator implements IncompatibilityComparator
{
    // processor0
    public $select0 = [
        'id',
    ];

    // processor1
    public $select1 = [
        'id',
    ];

    /**
     * @param ProcessorComponent $processor0
     * @param ProcessorComponent $processor1
     *
     * @return bool
     */
    public function isIncompatible($processor0, $processor1): bool
    {
        return $processor0->id !== $processor1->id;
    }
}
