<?php

namespace PCForge\Compatibility\Services;

use PCForge\Compatibility\Comparators\IncompatibilityComparator;
use PCForge\Compatibility\Contracts\ComparatorServiceContract;
use PCForge\Models\ComponentChild;

class ComparatorService implements ComparatorServiceContract
{
    /**
     * Gets the comparator that can compare the two given components. If none exists, then null is returned. The two
     * components should be provided in the natural order of their class names.
     *
     * @param ComponentChild $component1
     * @param ComponentChild $component2
     *
     * @return IncompatibilityComparator|null
     */
    public function get(ComponentChild $component1, ComponentChild $component2): ?IncompatibilityComparator
    {
        $class = '\PCForge\Compatibility\Comparators\\'
            . $this->componentToType($component1)
            . $this->componentToType($component2)
            . 'Comparator';

        return class_exists($class) ? resolve($class) : null;
    }

    /**
     * Converts a component to its type. E.g. 'ChassisComponent' becomes 'Chassis'.
     *
     * @param ComponentChild $component
     *
     * @return string
     */
    private function componentToType(ComponentChild $component): string
    {

        return substr(class_basename($component), 0, -strlen('Component'));
    }
}