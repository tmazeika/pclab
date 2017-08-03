<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\Contracts\SystemContract;
use PCForge\Models\PowerComponent;
use PCForge\Models\ProcessorComponent;

class PowerProcessorComparator implements IncompatibilityComparator
{
    /** @var SystemContract $system */
    private $system;

    public function __construct(SystemContract $system)
    {
        $this->system = $system;
    }

    /**
     * @param PowerComponent $power
     * @param ProcessorComponent $processor
     *
     * @return bool
     */
    public function isIncompatible($power, $processor): bool
    {
        return !$this->system->hasEnoughPower($processor, $power);
    }
}