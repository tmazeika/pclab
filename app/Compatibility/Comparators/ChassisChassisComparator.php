<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Models\ChassisComponent;

class ChassisChassisComparator implements IncompatibilityComparator
{
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