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

    public $with1 = [
        'form_factors' => [
            'id',
        ],
    ];

    // motherboard
    public $select2 = [
        'audio_headers',
        'fan_headers',
        'usb2_headers',
        'usb3_headers',
    ];

    public $with2 = [
        'form_factor',
    ];

    public $withSelect2 = [
        'form_factor' => [
            'id',
        ],
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
            || !$chassis->form_factors
                ->pluck('id')
                ->has($motherboard->form_factor->id);
    }

    public function getComponents(): array
    {
        return ['chassis', 'motherboard'];
    }
}
