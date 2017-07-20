<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\Helpers\System;
use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\PowerComponent;
use PCForge\Models\ProcessorComponent;

class PowerProcessorComparator implements IncompatibilityComparator
{
    // power
    public $select0 = [
        'watts_out',
    ];

    // processor
    public $with1 = [
        'parent',
    ];

    /** @var System $system */
    private $system;

    public function __construct(System $system)
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
