<?php

namespace PCForge\Compatibility\Providers;

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
    /** @var ComponentRepositoryContract $components */
    private $components;

    public function __construct(ComponentRepositoryContract $componentRepo)
    {
        $this->components = $componentRepo;
    }

    public function getStaticallyCompatible($component): Collection
    {
        $id = $component->id;

        return $this->components->withParent(MotherboardComponent::class)
            ->whereExists(function ($query) use ($id) {
                $query
                    ->select(DB::raw(1))
                    ->from('cooling_component_socket')
                    ->where('cooling_component_id', $id)
                    ->whereRaw('cooling_component_socket.socket_id = motherboard_components.socket_id');
            })
            ->pluck('components.id');
    }

    public function getStaticallyIncompatible($component): Collection
    {
        $id = $component->id;

        return collect([
            $this->components->withParent(ChassisComponent::class)
                ->where('max_cooling_fan_height', '<', $component->height)
                ->pluck('components.id'),
            // TODO: check radiators
            $this->components->withParent(CoolingComponent::class)
                ->where('cooling_components.id', '!=', $component->id)
                ->pluck('components.id'),
            $this->components->withParent(MemoryComponent::class)
                ->where('height', '>', $component->max_memory_height)
                ->pluck('components.id'),
            $this->components->withParent(MotherboardComponent::class)
                ->whereNotExists(function ($query) use ($id) {
                    $query
                        ->select(DB::raw(1))
                        ->from('cooling_component_socket')
                        ->where('cooling_component_id', $id)
                        ->whereRaw('cooling_component_socket.socket_id = motherboard_components.socket_id');
                })
                ->pluck('components.id'),
            $this->components->withParent(ProcessorComponent::class)
                ->whereNotExists(function ($query) use ($id) {
                    $query
                        ->select(DB::raw(1))
                        ->from('cooling_component_socket')
                        ->where('cooling_component_id', $id)
                        ->whereRaw("cooling_component_socket.socket_id = processor_components.socket_id");
                })
                ->pluck('components.id'),
        ])->flatten();
    }

    public function getDynamicallyCompatible($component, array $selection): Collection
    {
        return collect();
    }

    public function getDynamicallyIncompatible($component, array $selection): Collection
    {
        return collect();
    }
}
