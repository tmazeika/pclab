<?php

namespace PCLab\Compatibility\Comparators;

use PCLab\Models\ComponentChild;

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
}
