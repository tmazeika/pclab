<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\MotherboardComponent;
use PCForge\Models\PowerComponent;
use PCForge\Models\ProcessorComponent;

class MotherboardPowerComparator implements IncompatibilityComparator
{
    // motherboard
    public $select0 = [
        'socket_id',
    ];

    // power
    public $select1 = [
        'socket_id',
    ];

    /**
     * @param MotherboardComponent $motherboard
     * @param PowerComponent $power
     *
     * @return bool
     */
    public function isIncompatible($motherboard, $power): bool
    {
        return $power->atx12v_pins < $motherboard->atx12v_pins;
    }
}
