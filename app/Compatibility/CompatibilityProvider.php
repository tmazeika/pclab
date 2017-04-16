<?php

namespace PCForge\Compatibility;

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
     *
     * @return Collection
     */
    public function getDynamicallyCompatible($component): Collection;

    /**
     * Gets a collection of components that are incompatible with the given one based on the current selection.
     *
     * @param $component
     *
     * @return Collection
     */
    public function getDynamicallyIncompatible($component): Collection;

    /**
     * Gets the component type name for which this provides compatibilities.
     *
     * @return string
     */
    public function getComponentType(): string;
}
