<?php

namespace PCForge\Compatibility\Contracts;

use Illuminate\Support\Collection;
use PCForge\Models\ComponentChild;

interface ComponentRepositoryContract
{
    /**
     * Gets a collection of all available components.
     *
     * @return Collection
     */
    public function get(): Collection;

    /**
     * Finds a component by its ID in the collection of available components.
     *
     * @param int $id
     *
     * @return ComponentChild
     */
    public function find(int $id): ComponentChild;
}
