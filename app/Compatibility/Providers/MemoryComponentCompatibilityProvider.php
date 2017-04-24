<?php

namespace PCForge\Compatibility\Providers;

use Illuminate\Support\Collection;
use PCForge\Contracts\ComponentRepositoryContract;
use PCForge\Models\CoolingComponent;
use PCForge\Models\MemoryComponent;
use PCForge\Models\MotherboardComponent;

class MemoryComponentCompatibilityProvider implements CompatibilityProvider
{
    /** @var ComponentRepositoryContract $components */
    private $components;

    public function __construct(ComponentRepositoryContract $componentRepo)
    {
        $this->components = $componentRepo;
    }

    public function getStaticallyCompatible($component): Collection
    {
        return $this->components->withParent(MotherboardComponent::class)
            ->where('dimm_gen', $component->ddr_gen)
            ->where('dimm_pins', $component->pins)
            ->pluck('components.id')
            ->flatten();
    }

    public function getStaticallyIncompatible($component): Collection
    {
        return collect([
            $this->components->withParent(CoolingComponent::class)
                ->where('max_memory_height', '<', $component->height)
                ->pluck('components.id'),
            $this->components->withParent(MemoryComponent::class)
                ->where('memory_components.id', '!=', $component->id)
                ->pluck('components.id'),
            $this->components->withParent(MotherboardComponent::class)
                ->where('dimm_gen', '!=', $component->ddr_gen)
                ->orWhere('dimm_pins', '!=', $component->pins)
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
