<?php

namespace PCLab\Compatibility\Comparators;


use PCLab\Models\CoolingComponent;
use PCLab\Models\ProcessorComponent;

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