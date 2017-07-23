<?php

namespace PCForge\Contracts;

use Illuminate\Support\Collection;

interface ComponentRepositoryContract
{
    /**
     * Gets a collection of components, selecting certain columns and eager loading certain relations. The $selects
     * array should be component types, according to the morph map, each mapped to a list of columns. The $withs array
     * should be component types, each mapped to a map of relations, which are optionally mapped to a list of columns to
     * be selected on those relations.
     *
     * @param array $selects
     * @param array $withs
     *
     * @return Collection
     */
    public function get(array $selects, array $withs): Collection;
}
