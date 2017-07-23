<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\MotherboardComponent;

class MotherboardMotherboardComparator implements IncompatibilityComparator
{
    // motherboard 1
    public $select1 = [
        'id',
    ];

    // motherboard 2
    public $select2 = [
        'id',
    ];

    /**
     * @param MotherboardComponent $motherboard1
     * @param MotherboardComponent $motherboard2
     *
     * @return bool
     */
    public function isIncompatible($motherboard1, $motherboard2): bool
    {
        return $motherboard1->id !== $motherboard2->id;
    }
}
