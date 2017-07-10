<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\ChassisComponent;
use PCForge\Models\CoolingComponent;
use PCForge\Models\MotherboardComponent;

class ChassisCoolingComparator implements IncompatibilityComparator
{
    // chassis
    public $select0 = [
        'max_cooling_fan_height',
    ];

    // cooling
    public $select1 = [
        'height',
    ];

    /**
     * @param ChassisComponent $chassis
     * @param CoolingComponent $cooling
     *
     * @return bool
     */
    public function isIncompatible($chassis, $cooling): bool
    {
        // TODO: consider radiators
        return $cooling->height > $chassis->max_cooling_fan_height;
    }
}
