<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\Helpers\System;
use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Contracts\SystemContract;
use PCForge\Models\CoolingComponent;
use PCForge\Models\PowerComponent;

class CoolingPowerComparator implements IncompatibilityComparator
{
    // cooling
    public $with1 = [
        'parent' => [
            'watts_usage',
        ],
    ];

    // power
    public $select2 = [
        'watts_out',
    ];

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

    public function getComponents(): array
    {
        return ['cooling', 'power'];
    }
}
