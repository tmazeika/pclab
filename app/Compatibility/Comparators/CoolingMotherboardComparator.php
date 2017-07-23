<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\CoolingComponent;
use PCForge\Models\MotherboardComponent;

class CoolingMotherboardComparator implements IncompatibilityComparator
{
    // cooling
    public $with1 = [
        'sockets' => [
            'id',
        ],
    ];

    // motherboard
    public $select2 = [
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
        return $cooling->sockets
            ->pluck('id')
            ->contains($motherboard->socket_id);
    }
}
