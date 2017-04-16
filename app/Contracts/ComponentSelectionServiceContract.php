<?php

namespace PCForge\Contracts;

use PCForge\Models\ComponentChild;

interface ComponentSelectionServiceContract
{
    /**
     * Adds a component to the current selection with the given count.
     *
     * @param ComponentChild $component
     * @param int $count
     */
    public function select(ComponentChild $component, int $count): void;

    /**
     * Gets the selected count of the given component.
     *
     * @param ComponentChild $component
     *
     * @return int
     */
    public function getCount(ComponentChild $component): int;

    /**
     * Gets whether or not the given component is in the current selection.
     *
     * @param ComponentChild $component
     *
     * @return bool
     */
    public function isSelected(ComponentChild $component): bool;
}
