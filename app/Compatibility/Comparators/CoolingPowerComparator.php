<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\Helpers\System;
use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\CoolingComponent;
use PCForge\Models\PowerComponent;

class CoolingPowerComparator implements IncompatibilityComparator
{
    // cooling
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
     * @param CoolingComponent $cooling
     * @param PowerComponent $power
     *
     * @return bool
     */
    public function isIncompatible($cooling, $power): bool
    {
        return !$this->system->hasEnoughPower($cooling, $power);
    }
}
