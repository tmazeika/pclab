<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\Helpers\System;
use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Contracts\SystemContract;
use PCForge\Models\MotherboardComponent;
use PCForge\Models\PowerComponent;

class MotherboardPowerComparator implements IncompatibilityComparator
{
    // motherboard
    public $select1 = [
        'socket_id',
    ];

    public $with1 = [
        'parent' => [
            'watts_usage',
        ],
    ];

    // power
    public $select2 = [
        'socket_id',
        'watts_out',
    ];

    /** @var SystemContract $system */
    private $system;

    public function __construct(SystemContract $system)
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

    public function getComponents(): array
    {
        return ['motherboard', 'power'];
    }
}
