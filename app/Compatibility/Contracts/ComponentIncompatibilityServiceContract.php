<?php

namespace PCForge\Compatibility\Contracts;

use Illuminate\Support\Collection;
use PCForge\Models\ComponentChild;

interface ComponentIncompatibilityServiceContract
{
    /**
     * Gets a collection of components that are incompatible with the current selection.
     *
     * @return Collection
     */
    public function getIncompatibilities(): Collection;
}
