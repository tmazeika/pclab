<?php

namespace PCLab\Compatibility\Contracts;

use PCLab\Compatibility\Comparators\IncompatibilityComparator;
use PCLab\Models\ComponentChild;

interface ComparatorServiceContract
{
    /**
     * Gets whether or not the given components are directly incompatible.
     *
     * @param ComponentChild $component1
     * @param ComponentChild $component2
     *
     * @return bool
     *
     * @see IncompatibilityComparator::isIncompatible()
     */
    public function isIncompatible(ComponentChild $component1, ComponentChild $component2): bool;
}