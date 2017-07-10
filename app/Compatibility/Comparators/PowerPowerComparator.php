<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\MotherboardComponent;
use PCForge\Models\PowerComponent;
use PCForge\Models\ProcessorComponent;

class PowerPowerComparator implements IncompatibilityComparator
{
    // power0
    public $select0 = [
        'id',
    ];

    // power1
    public $select1 = [
        'id',
    ];

    /**
     * @param PowerComponent $power0
     * @param PowerComponent $power1
     *
     * @return bool
     */
    public function isIncompatible($power0, $power1): bool
    {
        // TODO: dynamic incompatibilities
        return $power0->id !== $power1->id;
    }
}
