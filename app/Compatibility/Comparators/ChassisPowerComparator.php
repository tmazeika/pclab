<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\Helpers\System;
use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\ChassisComponent;
use PCForge\Models\PowerComponent;

class ChassisPowerComparator implements IncompatibilityComparator
{
    // chassis
    public $with0 = [
        'parent',
    ];

    // power
    public $select1 = [
        'watts_out',
    ];

    /** @var System $system */
    private $system;

    public function __construct(System $system)
    {
        $this->system = $system;
    }

    /**
     * @param ChassisComponent $chassis
     * @param PowerComponent $power
     *
     * @return bool
     */
    public function isIncompatible($chassis, $power): bool
    {
        return !$this->system->hasEnoughPower($chassis, $power);
    }
}
