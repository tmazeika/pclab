<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\ChassisComponent;
use PCForge\Models\CoolingComponent;
use PCForge\Models\MemoryComponent;
use PCForge\Models\MotherboardComponent;

class CoolingMotherboardComparator implements IncompatibilityComparator
{
    // cooling
    public $with0 = [
        'sockets',
    ];

    // motherboard
    public $select1 = [
        'socket_id',
    ];

    /**
     * @param CoolingComponent $cooling
     * @param MotherboardComponent $motherboard
     *
     * @return bool
     */
    public function isIncompatible($cooling, $motherboard): bool
    {
        return $cooling->sockets->pluck('id')->contains($motherboard->socket_id);
    }
}
