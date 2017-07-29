<?php

namespace PCForge\Compatibility\Contracts;

use Illuminate\Support\Collection;
use PCForge\Models\ComponentChild;

interface ComponentIncompatibilityServiceContract
{
    /**
     * Gets a collection of components that are incompatible with the current selection. Optionally, an additional
     * component may be specified so that the selection effectively contains the addition, without actually adding it to
     * the selection.
     *
     * @param ComponentChild|null $additional
     *
     * @return Collection
     */
    public function getIncompatibilities(ComponentChild $additional = null): Collection;
}
