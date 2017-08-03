<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\Contracts\SystemContract;
use PCForge\Models\MemoryComponent;
use PCForge\Models\PowerComponent;

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