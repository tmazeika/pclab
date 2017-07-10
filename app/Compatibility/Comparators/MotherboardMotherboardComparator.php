<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\MotherboardComponent;
use PCForge\Models\ProcessorComponent;

class MotherboardMotherboardComparator implements IncompatibilityComparator
{
    // motherboard
    public $select0 = [
        'id',
    ];

    // motherboard
    public $select1 = [
        'id',
    ];

    /**
     * @param MotherboardComponent $motherboard0
     * @param MotherboardComponent $motherboard1
     *
     * @return bool
     */
    public function isIncompatible($motherboard0, $motherboard1): bool
    {
        // TODO: dynamic incompatibilities (storage counts)
        return $motherboard0->id !== $motherboard1->id;
    }
}
