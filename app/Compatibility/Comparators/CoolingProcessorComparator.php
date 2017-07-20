<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\CoolingComponent;
use PCForge\Models\ProcessorComponent;

class CoolingProcessorComparator implements IncompatibilityComparator
{
    // cooling
    public $with0 = [
        'sockets',
    ];

    // processor
    public $select1 = [
        'socket_id',
    ];

    /**
     * @param CoolingComponent $cooling
     * @param ProcessorComponent $processor
     *
     * @return bool
     */
    public function isIncompatible($cooling, $processor): bool
    {
        return $cooling->sockets->pluck('id')->contains($processor->socket_id);
    }
}
