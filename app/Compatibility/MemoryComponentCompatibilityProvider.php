<?php

namespace PCForge\Compatibility;

use Illuminate\Support\Collection;
use PCForge\Contracts\ComponentRepositoryContract;
use PCForge\Models\CoolingComponent;
use PCForge\Models\MemoryComponent;
use PCForge\Models\MotherboardComponent;

class MemoryComponentCompatibilityProvider implements CompatibilityProvider
{
    public function getStaticallyCompatible($component): Collection
    {
        // motherboard
        return MotherboardComponent
            ::where('dimm_gen', $component->ddr_gen)
            ->where('dimm_pins', $component->pins)
            ->pluck('component_id')
            ->flatten();
    }

    public function getStaticallyIncompatible($component): Collection
    {
        // cooling
        $components[] = CoolingComponent
            ::where('max_memory_height', '<', $component->height)
            ->pluck('component_id');

        // memory
        $components[] = MemoryComponent
            ::where('id', '!=', $component->id)
            ->pluck('component_id');

        // motherboard
        $components[] = MotherboardComponent
            ::where('dimm_gen', '!=', $component->ddr_gen)
            ->orWhere('dimm_pins', '!=', $component->pins)
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
        return 'memory';
    }
}
