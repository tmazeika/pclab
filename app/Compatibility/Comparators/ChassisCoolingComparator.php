<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\ChassisComponent;
use PCForge\Models\ChassisComponentsRadiator;
use PCForge\Models\CoolingComponent;

class ChassisCoolingComparator implements IncompatibilityComparator
{
    // chassis
    public $select0 = [
        'max_cooling_fan_height',
    ];

    // chassis
    public $with0 = [
        'radiators',
    ];

    // cooling
    public $select1 = [
        'fan_width',
        'height',
        'is_air',
        'radiator_length',
    ];

    /**
     * @param ChassisComponent $chassis
     * @param CoolingComponent $cooling
     *
     * @return bool
     */
    public function isIncompatible($chassis, $cooling): bool
    {
        if ($cooling->is_air) {
            return $cooling->height > $chassis->max_cooling_fan_height;
        }

        return $chassis->radiators->every(function (ChassisComponentsRadiator $radiator) use ($cooling) {
            return $cooling->fan_width > $radiator->max_fan_width || $cooling->radiator_length > $radiator->max_length;
        });
    }
}
