<?php

namespace PCForge\Contracts;

use Illuminate\Support\Collection;
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

    /**
     * Gets a collection of all selected components. Column selection may be specified, along with the component type
     * that should be returned.
     *
     * @param array $select
     * @param string $type
     *
     * @return Collection
     */
    public function allSelected(array $select = ['*'], string $type = ''): Collection;

    /**
     * Gets a collection of all selected components with a magic field 'count' set to the component's selected count.
     * Column selection may be specified, along with the component type that should be returned.
     *
     * @param array $select
     * @param string $type
     *
     * @return Collection
     */
    public function all(array $select = ['*'], string $type = ''): Collection;
}
