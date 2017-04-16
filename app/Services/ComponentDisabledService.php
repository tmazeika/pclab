<?php

namespace PCForge\Services;

use Illuminate\Support\Collection;
use PCForge\Contracts\ComponentDisabledServiceContract;
use PCForge\Models\ComponentChild;

class ComponentDisabledService implements ComponentDisabledServiceContract
{
    public function setDisabled(Collection $components): void
    {
        session(['disabled' => $components->map(function (ComponentChild $component) {
            return $component->id;
        })]);
    }

    /**
     * Gets whether or not the given component is disabled.
     *
     * @param ComponentChild $component
     *
     * @return bool
     */
    public function isDisabled(ComponentChild $component): bool
    {
        return in_array($component->id, session('disabled', []));
    }
}
