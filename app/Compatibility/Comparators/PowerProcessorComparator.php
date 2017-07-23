<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\Helpers\System;
use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Contracts\SystemContract;
use PCForge\Models\PowerComponent;
use PCForge\Models\ProcessorComponent;

class PowerProcessorComparator implements IncompatibilityComparator
{
    // power
    public $select1 = [
        'watts_out',
    ];

    // processor
    public $with2 = [
        'parent' => [
            'watts_usage',
        ],
    ];

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

    public function getComponents(): array
    {
        return ['power', 'processor'];
    }
}
