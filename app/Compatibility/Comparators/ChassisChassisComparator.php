<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\ChassisComponent;

class ChassisChassisComparator implements IncompatibilityComparator
{
    // chassis 1
    public $select1 = [
        'id',
    ];

    // chassis 2
    public $select2 = [
        'id',
    ];

    /**
     * @param ChassisComponent $chassis1
     * @param ChassisComponent $chassis2
     *
     * @return bool
     */
    public function isIncompatible($chassis1, $chassis2): bool
    {
        return $chassis1->id !== $chassis2->id;
    }
}
