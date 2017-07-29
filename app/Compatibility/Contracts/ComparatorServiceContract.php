<?php

namespace PCForge\Compatibility\Contracts;

use PCForge\Compatibility\Comparators\IncompatibilityComparator;
use PCForge\Models\ComponentChild;

interface ComparatorServiceContract
{
    public function get(ComponentChild $component1, ComponentChild $component2): ?IncompatibilityComparator;
}