<?php

namespace PCForge\Compatibility\Comparators;


use PCForge\Contracts\SystemContract;
use PCForge\Models\ChassisComponent;
use PCForge\Models\GraphicsComponent;

class ChassisGraphicsComparator implements IncompatibilityComparator
{
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

    public function getComponents(): array
    {
        return ['chassis', 'graphics'];
    }

    private function isHddCageRequired(ChassisComponent $chassis): bool
    {
        list($avail2p5, $avail3p5, $availAdapt) = $this->system->getAvailableBayCounts($chassis);

        return $avail2p5 < $chassis->cage_2p5_bays
            || $avail3p5 < $chassis->cage_3p5_bays
            || $availAdapt < $chassis->cage_adaptable_bays;
    }
}
