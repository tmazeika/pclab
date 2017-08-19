<?php

namespace PCLab\Compatibility\Comparators;

use PCLab\Compatibility\Contracts\SystemContract;
use PCLab\Models\CoolingComponent;
use PCLab\Models\PowerComponent;

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