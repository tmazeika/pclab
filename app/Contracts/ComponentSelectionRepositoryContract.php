<?php

namespace PCForge\Contracts;

use Illuminate\Support\Collection;

interface ComponentSelectionRepositoryContract
{
    /**
     * Selects a component the given number of times.
     *
     * @param int $id the ID of the component
     * @param int $count the number of times to be selected
     */
    public function select(int $id, int $count): void;

    /**
     * Gets the number of times the given component has been selected.
     *
     * @param int $id the ID of the component
     *
     * @return int the number of times the component has been selected
     */
    public function getSelectionCount(int $id): int;

    /**
     * Gets if the given component is selected.
     *
     * @param int $id the ID of the component
     *
     * @return bool true if the component is selected
     */
    public function isSelected(int $id): bool;

    /**
     * Gets an association between selected component ID's and the number of times they've been selected.
     *
     * @return array
     */
    public function all(): array;
}
