<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\Helpers\System;
use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\ChassisComponent;
use PCForge\Models\GraphicsComponent;

class ChassisGraphicsComparator implements IncompatibilityComparator
{
    // chassis
    public $select1 = [
        '2p5_bays',
        '3p5_bays',
        'adaptable_bays',
        'cage_2p5_bays',
        'cage_3p5_bays',
        'cage_adaptable_bays',
        'max_graphics_length_blocked',
        'max_graphics_length_full',
    ];

    // graphics
    public $select2 = [
        'length',
    ];

    /** @var System $system */
    private $system;

    public function __construct(System $system)
    {
        $this->system = $system;
    }

    /**
     * @param ChassisComponent $chassis
     * @param GraphicsComponent $graphics
     *
     * @return bool
     */
    public function isIncompatible($chassis, $graphics): bool
    {
        return ($this->isHddCageRequired($chassis)
                ? $chassis->max_graphics_length_blocked
                : $chassis->max_graphics_length_full)
            > $graphics->length;
    }

    private function isHddCageRequired(ChassisComponent $chassis): bool
    {
        list($avail2p5, $avail3p5, $availAdapt) = $this->system->getAvailableBayCounts($chassis);

        return $avail2p5 < $chassis->cage_2p5_bays
            || $avail3p5 < $chassis->cage_3p5_bays
            || $availAdapt < $chassis->cage_adaptable_bays;
    }
}
