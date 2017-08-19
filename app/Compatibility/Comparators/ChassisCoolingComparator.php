<?php

namespace PCLab\Compatibility\Comparators;

use PCLab\Models\ChassisComponent;
use PCLab\Models\RadiatorConfiguration;
use PCLab\Models\CoolingComponent;

class ChassisCoolingComparator implements IncompatibilityComparator
{
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

        return $chassis->radiators->every(function (RadiatorConfiguration $radiator) use ($cooling) {
            return $cooling->fan_width > $radiator->max_fan_width || $cooling->radiator_length > $radiator->max_length;
        });
    }
}
