<?php

namespace PCLab\Compatibility\Comparators;


use PCLab\Models\MotherboardComponent;
use PCLab\Models\ProcessorComponent;

class MotherboardProcessorComparator implements IncompatibilityComparator
{
    /**
     * @param MotherboardComponent $motherboard
     * @param ProcessorComponent $processor
     *
     * @return bool
     */
    public function isIncompatible($motherboard, $processor): bool
    {
        return $motherboard->socket_id !== $processor->socket_id;
    }
}