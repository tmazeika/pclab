<?php

namespace PCForge\Compatibility\Contracts;

use Illuminate\Support\Collection;

interface ComponentRepositoryContract
{
    /**
     * Gets a collection of all or only available components, specified by $available.
     *
     * @param bool $filterAvailable
     *
     * @return Collection
     */
    public function get(bool $filterAvailable = true): Collection;
}
