<?php

namespace PCForge\Compatibility\Contracts;

use Illuminate\Support\Collection;
use PCForge\Models\ComponentChild;

interface SelectionContract
{
    /**
     * Sets the $selectCount and $disabled properties on each component in the given collection.
     *
     * @param Collection $components
     */
    public function setProperties(Collection $components): void;

    /**
     * Selects the given component $n number of times. An $n of 0 deselects it.
     *
     * @param ComponentChild $component
     * @param int $n
     */
    public function select(ComponentChild $component, int $n): void;

    /**
     * Disables only the given components, enabling all else.
     *
     * @param array $components
     */
    public function disableOnly(array $components): void;

    /**
     * Gets the selection count of the given component.
     *
     * @param ComponentChild $component
     *
     * @return int
     */
    public function getSelectCount(ComponentChild $component): int;

    /**
     * Gets if the given component is disabled.
     *
     * @param ComponentChild $component
     *
     * @return bool
     */
    public function isDisabled(ComponentChild $component): bool;

    /**
     * Gets all selected components.
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Gets all selected components of the given class.
     *
     * @param string $class
     *
     * @return Collection
     */
    public function getAllOfType(string $class): Collection;

    /**
     * Gets the map of component ID's to their selected counts.
     *
     * @return array
     */
    public function getCounts(): array;
}