<?php

namespace PCForge\Contracts;

use Illuminate\Support\Collection;

interface ComponentIncompatibilityServiceContract
{
    /**
     * Gets a collection of components that are incompatible with the current selection.
     *
     * @return Collection
     */
    public function getIncompatibilities(): Collection;
}
