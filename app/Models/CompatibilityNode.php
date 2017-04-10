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
    public function getStaticallyCompatibleComponents(): array;

    /**
     * Gets all components that are directly incompatible with this component. More specifically, the components that
     * can be reliably deemed incompatible with this component while disregarding the presence of other components in
     * the build.
     *
     * @return int[] an array of component ID's
     */
    public function getStaticallyIncompatibleComponents(): array;

    /**
     * Gets all components that are compatible with this component based on some other session specific parameters.
     * Similar to getAllDirectlyCompatibleComponents, but this function determines compatibility using parameters that
     * are unique to each session, such as count and presence of other selected components.
     *
     * @param array $selected an association between component ID's and the number of times they were
     * selected
     *
     * @return int[] an array of component ID's
     *
     * @see getStaticallyCompatibleComponents
     */
    public function getDynamicallyCompatibleComponents(array $selected): array;

    /**
     * Gets all components that are incompatible with this component based on some other session specific parameters.
     * Similar to getAllDirectlyIncompatibleComponents, but this function determines incompatibility using parameters
     * that are unique to each session, such as count and presence of other selected components.
     *
     * @param array $selected an association between component ID's and the number of times they were
     * selected
     *
     * @return int[] an array of component ID's
     *
     * @see getStaticallyIncompatibleComponents
     */
    public function getDynamicallyIncompatibleComponents(array $selected): array;
}
