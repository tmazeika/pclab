<?php

namespace PCForge\Compatibility\Contracts;

use Illuminate\Support\Collection;
use PCForge\Models\ComponentChild;

interface SelectionContract
{
    /**
     * Selects the given component by setting its $selectCount property to 1 and adding it to the list of selected
     * components.
     *
     * @param ComponentChild $component
     */
    public function select(ComponentChild $component): void;

    /**
     * Deselects the given component by setting its $selectCount property to 0 and removing it from the list of selected
     * components.
     *
     * @param ComponentChild $component
     */
    public function deselect(ComponentChild $component): void;

    /**
     * Gets the collection of selected components of the given class.
     *
     * @param string $class
     *
     * @return Collection
     */
    public function getAllOfType(string $class): Collection;

    /**
     * Gets the collection of all selected components.
     *
     * @return Collection
     */
    public function getAll(): Collection;
}