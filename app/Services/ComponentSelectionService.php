<?php

namespace PCForge\Repositories;

use Illuminate\Support\Collection;
use PCForge\Contracts\ComponentSelectionRepositoryContract;
use PCForge\Contracts\ComponentSelectionServiceContract;
use PCForge\Models\ComponentChild;

class ComponentSelectionService implements ComponentSelectionServiceContract
{
    /**
     * Adds a component to the current selection with the given count.
     *
     * @param ComponentChild $component
     * @param int $count
     */
    public function select(ComponentChild $component, int $count): void
    {
        if ($count > 0) {
            session(["selected.$component->component_id" => $count]);
        } else {
            session()->forget("selected.$component->component_id");
        }
    }

    /**
     * Gets the selected count of the given component.
     *
     * @param ComponentChild $component
     *
     * @return int
     */
    public function getCount(ComponentChild $component): int
    {
        return session("selected.$component->component_id", 0);
    }

    /**
     * Gets whether or not the given component is in the current selection.
     *
     * @param ComponentChild $component
     *
     * @return bool
     */
    public function isSelected(ComponentChild $component): bool
    {
        return $this->getCount($component) > 0;
    }
}
