<?php

namespace PCForge\Contracts;

use Illuminate\Support\Collection;

interface ComponentRepositoryContract
{
    /**
     * Gets a collection of all or only available components, specified by $available.
     *
     * @param bool $onlyAvailable
     *
     * @return Collection
     */
    public function get(bool $onlyAvailable): Collection;
}
