<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\MotherboardComponent;
use PCForge\Models\ProcessorComponent;

class MotherboardProcessorComparator implements IncompatibilityComparator
{
    // motherboard
    public $select1 = [
        'socket_id',
    ];

    // processor
    public $select2 = [
        'socket_id',
    ];

    /**
     * Gets whether or not both given components are incompatible with each other. A return value of false does not mean
     * that the components are necessarily compatible.
     *
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
