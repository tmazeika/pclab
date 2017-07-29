<?php

namespace PCForge\Compatibility\Comparators;


use PCForge\Models\ChassisComponent;
use PCForge\Models\MotherboardComponent;

class ChassisMotherboardComparator implements IncompatibilityComparator
{
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