<?php

namespace PCForge\Contracts;

use Illuminate\Support\Collection;
use PCForge\Models\ComponentChild;

interface ComponentDisabledServiceContract
{
    /**
     * Disables the given components, enabling all other components that are not included in the given collection.
     *
     * @param Collection $components
     */
    public function setDisabled(Collection $components): void;

    /**
     * Gets whether or not the given component is disabled.
     *
     * @param ComponentChild $component
     *
     * @return bool
     */
    public function isDisabled(ComponentChild $component): bool;
}
