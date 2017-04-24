<?php

namespace PCForge\Compatibility\Providers;

use Illuminate\Support\Collection;

interface CompatibilityProvider
{
    /**
     * Gets a collection of components that are compatible with the given one.
     *
     * @param $component
     *
     * @return Collection
     */
    public function getStaticallyCompatible($component): Collection;

    /**
     * Gets a collection of components that are incompatible with the given one.
     *
     * @param $component
     *
     * @return Collection
     */
    public function getStaticallyIncompatible($component): Collection;

    /**
     * Gets a collection of components that are compatible with the given one based on the current selection.
     *
     * @param $component
     * @param array $selection
     *
     * @return Collection
     */
    public function getDynamicallyCompatible($component, array $selection): Collection;

    /**
     * Gets a collection of components that are incompatible with the given one based on the current selection.
     *
     * @param $component
     * @param array $selection
     *
     * @return Collection
     */
    public function getDynamicallyIncompatible($component, array $selection): Collection;
}
