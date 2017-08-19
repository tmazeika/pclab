<?php

namespace PCLab\Compatibility\Comparators;

use PCLab\Compatibility\Contracts\SystemContract;
use PCLab\Models\MotherboardComponent;
use PCLab\Models\PowerComponent;

class MotherboardPowerComparator implements IncompatibilityComparator
{
    /** @var SystemContract $system */
    private $system;

    public function __construct(SystemContract $system)
    {
        $this->system = $system;
    }

    /**
     * @param MotherboardComponent $motherboard
     * @param PowerComponent $power
     *
     * @return bool
     */
    public function isIncompatible($motherboard, $power): bool
    {
        return $power->atx12v_pins < $motherboard->atx12v_pins || !$this->system->hasEnoughPower($motherboard, $power);
    }
}