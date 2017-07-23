<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\Helpers\System;
use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\MemoryComponent;
use PCForge\Models\PowerComponent;

class MemoryPowerComparator implements IncompatibilityComparator
{
    // memory
    public $with1 = [
        'parent' => [
            'watts_usage',
        ],
    ];

    // power
    public $select2 = [
        'watts_out',
    ];

    /** @var System $system */
    private $system;

    public function __construct(System $system)
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
