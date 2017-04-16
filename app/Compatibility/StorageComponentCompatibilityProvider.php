<?php

namespace PCForge\Compatibility;

use Illuminate\Support\Collection;
use PCForge\Contracts\ComponentRepositoryContract;

class StorageComponentCompatibilityProvider implements CompatibilityProvider
{
    public function getStaticallyCompatible($component): Collection
    {
        return collect($component->id);
    }

    public function getStaticallyIncompatible($component): Collection
    {
        return collect();
    }

    public function getDynamicallyCompatible($component): Collection
    {
        return collect();
    }

    public function getDynamicallyIncompatible($component): Collection
    {
        return collect();
    }

    public function getComponentType(): string
    {
        return 'storage';
    }
}
