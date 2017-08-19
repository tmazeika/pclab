<?php

namespace PCLab\Compatibility\Services;

use PCLab\Compatibility\Comparators\IncompatibilityComparator;
use PCLab\Compatibility\Contracts\ComparatorServiceContract;
use PCLab\Models\ComponentChild;

class ComparatorService implements ComparatorServiceContract
{
    public function isIncompatible(ComponentChild $component1, ComponentChild $component2): bool
    {
        // sort components by class name in alphabetical order
        $components = array_sort([$component1, $component2], function ($component) {
            return get_class($component);
        });

        $comparator = $this->getComparator(...$components);

        return $comparator !== null && $comparator->isIncompatible(...$components);
    }

    /**
     * Gets the comparator that can compare the given components. If none exists, null is returned. The components
     * should be passed in alphabetical order by their class names.
     *
     * @param ComponentChild $component1
     * @param ComponentChild $component2
     *
     * @return IncompatibilityComparator|null
     */
    private function getComparator(ComponentChild $component1, ComponentChild $component2): ?IncompatibilityComparator
    {
        $class = '\PCLab\Compatibility\Comparators\\'
            . $this->componentToType($component1)
            . $this->componentToType($component2)
            . 'Comparator';

        return class_exists($class) ? app()->make($class) : null;
    }

    /**
     * Converts a component to its type name. E.g. 'ChassisComponent' becomes 'Chassis'.
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