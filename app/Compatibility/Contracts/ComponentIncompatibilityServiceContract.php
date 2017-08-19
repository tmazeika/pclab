<?php

namespace PCLab\Compatibility\Contracts;

use Illuminate\Support\Collection;
use PCLab\Models\ComponentChild;

interface ComponentIncompatibilityServiceContract
{
    /**
     * Gets a collection of components that are incompatible with the current selection.
     *
     * @return Collection
     */
    public function getIncompatibilities(): Collection;
}
