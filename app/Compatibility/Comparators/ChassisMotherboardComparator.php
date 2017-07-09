<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\ChassisComponent;
use PCForge\Models\MotherboardComponent;

class ChassisMotherboardComparator implements IncompatibilityComparator
{
    // chassis
    public $select1 = [
        'audio_headers',
        'fan_headers',
        'usb2_headers',
        'usb3_headers',
    ];

    // chassis
    public $with1 = [
        'form_factors',
    ];

    // motherboard
    public $select2 = [
        'audio_headers',
        'fan_headers',
        'usb2_headers',
        'usb3_headers',
    ];

    // motherboard
    public $with2 = [
        'form_factor',
    ];

    /**
     * Gets whether or not both given components are incompatible with each other. A return value of false does not mean
     * that the components are necessarily compatible.
     *
     * @param ChassisComponent $chassis
     * @param MotherboardComponent $motherboard
     *
     * @return bool
     */
    public function isIncompatible($chassis, $motherboard): bool
    {
        return $chassis->audio_headers > $motherboard->audio_headers
            || $chassis->fan_headers > $motherboard->fan_headers
            || $chassis->usb2_headers > $motherboard->usb2_headers
            || $chassis->usb3_headers > $motherboard->usb3_headers
            || !$chassis->form_factors()->pluck('id')->has($motherboard->form_factor->id);
    }
}
