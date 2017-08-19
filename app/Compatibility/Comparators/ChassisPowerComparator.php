<?php

namespace PCLab\Compatibility\Comparators;

use PCLab\Compatibility\Contracts\SystemContract;
use PCLab\Models\ChassisComponent;
use PCLab\Models\PowerComponent;

class ChassisPowerComparator implements IncompatibilityComparator
{
    /** @var SystemContract $system */
    private $system;

    public function __construct(SystemContract $system)
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