<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\ChassisComponent;
use PCForge\Models\CoolingComponent;
use PCForge\Models\GraphicsComponent;
use PCForge\Models\MotherboardComponent;

class ChassisGraphicsComparator implements IncompatibilityComparator
{
    // chassis
    public $select0 = [
        'max_graphics_length_blocked',
    ];

    // graphics
    public $select1 = [
        'length',
    ];

    /**
     * @param ChassisComponent $chassis
     * @param GraphicsComponent $graphics
     *
     * @return bool
     */
    public function isIncompatible($chassis, $graphics): bool
    {
        return $chassis->max_cooling_fan_height > $graphics->length;
    }
}
