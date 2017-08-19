<?php

namespace PCLab\Compatibility\Comparators;

use PCLab\Compatibility\Contracts\SystemContract;
use PCLab\Models\MemoryComponent;
use PCLab\Models\PowerComponent;

class MemoryPowerComparator implements IncompatibilityComparator
{
    /** @var SystemContract $system */
    private $system;

    public function __construct(SystemContract $system)
    {
        $this->system = $system;
    }

    /**
     * @param MemoryComponent $memory
     * @param PowerComponent $power
     *
     * @return bool
     */
    public function isIncompatible($memory, $power): bool
    {
        return !$this->system->hasEnoughPower($memory, $power);
    }
}