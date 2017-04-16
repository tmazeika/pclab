<?php

namespace PCForge\Compatibility;

use Illuminate\Support\Collection;
use PCForge\Contracts\ComponentRepositoryContract;
use PCForge\Models\MotherboardComponent;
use PCForge\Models\ProcessorComponent;

class ProcessorComponentCompatibilityProvider implements CompatibilityProvider
{
    public function getStaticallyCompatible($component): Collection
    {
        // motherboard
        return MotherboardComponent
            ::where('socket_id', $component->socket_id)
            ->pluck('component_id')
            ->flatten();
    }

    public function getStaticallyIncompatible($component): Collection
    {
        // motherboard
        $components[] = MotherboardComponent
            ::where('socket_id', '!=', $component->socket_id)
            ->pluck('component_id');

        // processor
        $components[] = ProcessorComponent
            ::where('id', '!=', $component->id)
            ->pluck('component_id');

        return collect($components)->flatten();
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
        return 'processor';
    }
}
