<?php

namespace PCForge\Models;

interface CompatibilityNode
{
    /**
     * Gets all components that are directly compatible with this component. More specifically, the components that can
     * be reliably deemed compatible with this component while disregarding the presence of other components in the
     * build.
     *
     * @return int[] an array of component ID's
     */
    public function getAllDirectlyCompatibleComponents(): array;

    /**
     * Gets all components that are directly incompatible with this component. More specifically, the components that
     * can be reliably deemed incompatible with this component while disregarding the presence of other components in
     * the build.
     *
     * @return int[] an array of component ID's
     */
    public function getAllDirectlyIncompatibleComponents(): array;
}
