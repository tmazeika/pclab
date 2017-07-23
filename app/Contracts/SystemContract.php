<?php

namespace PCForge\Contracts;

use PCForge\Models\ChassisComponent;
use PCForge\Models\ComponentChild;
use PCForge\Models\PowerComponent;

interface SystemContract
{
    /**
     * Gets whether or not the given component is able to be sufficiently powered with the given power supply, taking
     * into account other components currently in the build.
     *
     * @param ComponentChild $component
     * @param PowerComponent $power
     *
     * @return bool
     */
    public function hasEnoughPower(ComponentChild $component, PowerComponent $power): bool;

    /**
     * Gets a list of storage bay availability in the order of 2p5, 3p5, and adaptable.
     *
     * @param ChassisComponent $chassis
     *
     * @return array
     */
    public function getAvailableBayCounts(ChassisComponent $chassis): array;
}