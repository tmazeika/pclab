<?php

namespace PCForge\Compatibility\Contracts;

use PCForge\Compatibility\Comparators\IncompatibilityComparator;
use PCForge\Models\ComponentChild;

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