<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\ProcessorComponent;

class ProcessorProcessorComparator implements IncompatibilityComparator
{
    // processor 1
    public $select1 = [
        'id',
    ];

    // processor 2
    public $select2 = [
        'id',
    ];

    /**
     * @param ProcessorComponent $processor1
     * @param ProcessorComponent $processor2
     *
     * @return bool
     */
    public function isIncompatible($processor1, $processor2): bool
    {
        return $processor1->id !== $processor2->id;
    }
}
