<?php

namespace PCForge\Compatibility\Providers;

use Illuminate\Support\Collection;
use PCForge\Contracts\ComponentRepositoryContract;
use PCForge\Models\Component;
use PCForge\Models\MotherboardComponent;
use PCForge\Models\ProcessorComponent;

class ProcessorComponentCompatibilityProvider implements CompatibilityProvider
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
            ->where('socket_id', $component->socket_id)
            ->pluck('components.id');
    }

    public function getStaticallyIncompatible($component): Collection
    {
        return collect([
            $this->components->withParent(MotherboardComponent::class)
                ->where('socket_id', '!=', $component->socket_id)
                ->pluck('components.id'),
            $this->components->withParent(ProcessorComponent::class)
                ->where('processor_components.id', '!=', $component->id)
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
