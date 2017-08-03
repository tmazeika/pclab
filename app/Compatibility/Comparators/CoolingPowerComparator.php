<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\Contracts\SystemContract;
use PCForge\Models\CoolingComponent;
use PCForge\Models\PowerComponent;

class CoolingPowerComparator implements IncompatibilityComparator
{
    /** @var SystemContract $system */
    private $system;

    public function __construct(SystemContract $system)
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