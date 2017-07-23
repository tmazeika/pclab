<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\CoolingComponent;

class CoolingCoolingComparator implements IncompatibilityComparator
{
    // cooling 1
    public $select1 = [
        'id',
    ];

    // cooling 2
    public $select2 = [
        'id',
    ];

    /**
     * @param CoolingComponent $cooling1
     * @param CoolingComponent $cooling2
     *
     * @return bool
     */
    public function isIncompatible($cooling1, $cooling2): bool
    {
        return $cooling1->id !== $cooling2->id;
    }
}
