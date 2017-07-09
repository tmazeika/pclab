<?php

namespace PCForge\Contracts;

use Illuminate\Support\Collection;

interface ComponentRepositoryContract
{
    /**
     * Gets a collection of all components
     *
     * @param array $selects
     * @param array $withs
     *
     * @return Collection
     */
    public function all(array $selects = ['*'], array $withs = []): Collection;
}
