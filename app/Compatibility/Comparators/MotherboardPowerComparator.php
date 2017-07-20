<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\Helpers\System;
use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\MotherboardComponent;
use PCForge\Models\PowerComponent;

class MotherboardPowerComparator implements IncompatibilityComparator
{
    // motherboard
    public $select0 = [
        'socket_id',
    ];

    // motherboard
    public $with0 = [
        'parent',
    ];

    // power
    public $select1 = [
        'socket_id',
        'watts_out',
    ];

    /** @var System $system */
    private $system;

    public function __construct(System $system)
    {
        $this->system;
    }

    /**
     * @param MotherboardComponent $motherboard
     * @param PowerComponent $power
     *
     * @return bool
     */
    public function isIncompatible($motherboard, $power): bool
    {
        return $power->atx12v_pins < $motherboard->atx12v_pins || $this->system->hasEnoughPower($motherboard, $power);
    }
}
