<?php

namespace PCForge\Contracts;

use Illuminate\Support\Collection;

interface ComponentCompatibilityServiceContract
{
    /**
     * Computes a collection of components that are incompatible with the current selection.
     *
     * @return Collection
     */
    public function computeIncompatibilities(): Collection;
}
