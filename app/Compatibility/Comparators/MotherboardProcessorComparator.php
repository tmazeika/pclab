<?php

namespace PCForge\Compatibility\Comparators;


use PCForge\Models\MotherboardComponent;
use PCForge\Models\ProcessorComponent;

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