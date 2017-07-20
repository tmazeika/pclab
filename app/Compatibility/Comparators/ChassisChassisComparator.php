<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\ChassisComponent;

class ChassisChassisComparator implements IncompatibilityComparator
{
    // chassis0
    public $select0 = [
        'id',
    ];

    // chassis1
    public $select1 = [
        'id',
    ];

    /**
     * @param ChassisComponent $chassis0
     * @param ChassisComponent $chassis1
     *
     * @return bool
     */
    public function isIncompatible($chassis0, $chassis1): bool
    {
        return $chassis0->id !== $chassis1->id;
    }
}
