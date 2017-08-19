<?php

namespace PCLab\Compatibility\Comparators;

use PCLab\Compatibility\Contracts\SystemContract;
use PCLab\Models\PowerComponent;
use PCLab\Models\ProcessorComponent;

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