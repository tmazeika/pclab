<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\Helpers\System;
use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\MemoryComponent;
use PCForge\Models\PowerComponent;

class MemoryPowerComparator implements IncompatibilityComparator
{
    // memory
    public $with0 = [
        'parent',
    ];

    // power
    public $select1 = [
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
