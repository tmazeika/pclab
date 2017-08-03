<?php

namespace PCForge\Compatibility\Comparators;


use PCForge\Models\CoolingComponent;
use PCForge\Models\ProcessorComponent;

class CoolingProcessorComparator implements IncompatibilityComparator
{
    /**
     * @param CoolingComponent $cooling
     * @param ProcessorComponent $processor
     *
     * @return bool
     */
    public function isIncompatible($cooling, $processor): bool
    {
        return !$cooling->sockets->pluck('id')->contains($processor->socket_id);
    }
}