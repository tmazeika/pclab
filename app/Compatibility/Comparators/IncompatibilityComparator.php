<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Models\ComponentChild;

interface IncompatibilityComparator
{
    /**
     * Gets whether or not the given components are directly incompatible. The components should be passed in the order
     * that they appear in the implementation's class name (alphabetically).
     *
     * @param ComponentChild $component1
     * @param ComponentChild $component2
     *
     * @return bool
     */
    public function isIncompatible($component1, $component2): bool;

    /**
     * Gets the pair of components that are compared in this comparator.
     *
     * @return array
     */
    public function getComponents(): array;
}
