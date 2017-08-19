<?php

namespace PCLab\Compatibility\Comparators;


use PCLab\Models\CoolingComponent;
use PCLab\Models\MotherboardComponent;

class CoolingMotherboardComparator implements IncompatibilityComparator
{
    /**
     * @param CoolingComponent $cooling
     * @param MotherboardComponent $motherboard
     *
     * @return bool
     */
    public function isIncompatible($cooling, $motherboard): bool
    {
        return !$cooling->sockets->pluck('id')->contains($motherboard->socket_id);
    }
}