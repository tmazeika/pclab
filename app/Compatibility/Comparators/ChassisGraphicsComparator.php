<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\Contracts\SystemContract;
use PCForge\Models\ChassisComponent;
use PCForge\Models\GraphicsComponent;

class ChassisGraphicsComparator implements IncompatibilityComparator
{
    /** @var SystemContract $system */
    private $system;

    public function __construct(SystemContract $system)
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
        $max = $this->isHddCageRequired($chassis)
            ? $chassis->max_graphics_length_blocked
            : $chassis->max_graphics_length_full;

        return $graphics->length > $max;
    }
}