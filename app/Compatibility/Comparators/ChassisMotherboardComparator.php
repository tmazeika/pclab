<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\ChassisComponent;
use PCForge\Models\MotherboardComponent;

class ChassisMotherboardComparator implements IncompatibilityComparator
{
    // chassis
    public $select0 = [
        'audio_headers',
        'fan_headers',
        'usb2_headers',
        'usb3_headers',
    ];

    // chassis
    public $with0 = [
        'form_factors',
    ];

    // motherboard
    public $select1 = [
        'audio_headers',
        'fan_headers',
        'usb2_headers',
        'usb3_headers',
    ];

    // motherboard
    public $with1 = [
        'form_factor',
    ];

    /**
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
            || !$chassis
                ->form_factors()
                ->pluck('id')
                ->has($motherboard->form_factor->id);
    }
}
