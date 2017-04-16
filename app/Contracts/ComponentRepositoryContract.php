<?php

namespace PCForge\Contracts;

use Illuminate\Support\Collection;

interface ComponentRepositoryContract
{
    /**
     * Builds a collection of reachable components, grouped by type, each converted to the component child.
     *
     * @return Collection
     */
    public function buildGroupedReachable(): Collection;

    /**
     * Computes a collection of reachable components when no components are selected. Column selection may be specified.
     *
     * @param array $select
     *
     * @return Collection
     */
    public function computeReachable($select = ['*']): Collection;

    /**
     * Computes a collection of unreachable components due to unavailability or due to reliance on another component
     * that is unreachable.
     *
     * @return Collection
     */
    public function computeUnreachable(): Collection;
}
