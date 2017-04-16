<?php

namespace PCForge\Compatibility;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use PCForge\Contracts\ComponentRepositoryContract;
use PCForge\Models\ChassisComponent;
use PCForge\Models\CoolingComponent;
use PCForge\Models\MemoryComponent;
use PCForge\Models\MotherboardComponent;
use PCForge\Models\ProcessorComponent;

class CoolingComponentCompatibilityProvider implements CompatibilityProvider
{
    public function getStaticallyCompatible($component): Collection
    {
        $id = $component->id;

        // motherboard
        $components[] = MotherboardComponent
            ::whereExists(function ($query) use ($id) {
                $query
                    ->select(DB::raw(1))
                    ->from('cooling_component_socket')
                    ->where('cooling_component_id', $id)
                    ->whereRaw('cooling_component_socket.socket_id = motherboard_components.socket_id');
            })
            ->pluck('component_id');

        return collect($components)->flatten();
    }

    public function getStaticallyIncompatible($component): Collection
    {
        $id = $component->id;

        // chassis TODO: check radiators
        $components[] = ChassisComponent
            ::where('max_cooling_fan_height', '<', $component->height)
            ->pluck('component_id');

        // cooling
        $components[] = CoolingComponent
            ::where('id', '!=', $component->id)
            ->pluck('component_id');

        // memory
        $components[] = MemoryComponent
            ::where('height', '>', $component->max_memory_height)
            ->pluck('component_id');

        // motherboard
        $components[] = MotherboardComponent
            ::whereNotExists(function ($query) use ($id) {
                $query
                    ->select(DB::raw(1))
                    ->from('cooling_component_socket')
                    ->where('cooling_component_id', $id)
                    ->whereRaw('cooling_component_socket.socket_id = motherboard_components.socket_id');
            })
            ->pluck('component_id');

        // processor
        $components[] = ProcessorComponent
            ::whereNotExists(function ($query) use ($id) {
                $query
                    ->select(DB::raw(1))
                    ->from('cooling_component_socket')
                    ->where('cooling_component_id', $id)
                    ->whereRaw("cooling_component_socket.socket_id = processor_components.socket_id");
            })
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
        return 'cooling';
    }
}
