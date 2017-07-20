<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\CoolingComponent;

class CoolingCoolingComparator implements IncompatibilityComparator
{
    // cooling0
    public $select0 = [
        'id',
    ];

    // cooling1
    public $select1 = [
        'id',
    ];

    /**
     * @param CoolingComponent $cooling0
     * @param CoolingComponent $cooling1
     *
     * @return bool
     */
    public function isIncompatible($cooling0, $cooling1): bool
    {
        return $cooling0->id !== $cooling1->id;
    }
}
