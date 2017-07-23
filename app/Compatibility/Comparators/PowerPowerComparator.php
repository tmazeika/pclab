<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\PowerComponent;

class PowerPowerComparator implements IncompatibilityComparator
{
    // power 1
    public $select1 = [
        'id',
    ];

    // power 2
    public $select2 = [
        'id',
    ];

    /**
     * @param PowerComponent $power1
     * @param PowerComponent $power2
     *
     * @return bool
     */
    public function isIncompatible($power1, $power2): bool
    {
        return $power1->id !== $power2->id;
    }

    public function getComponents(): array
    {
        return ['power', 'power'];
    }
}
