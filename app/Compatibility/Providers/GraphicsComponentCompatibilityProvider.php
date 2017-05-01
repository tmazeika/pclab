<?php

namespace PCForge\Compatibility\Providers;

use Illuminate\Support\Collection;
use PCForge\Contracts\ComponentRepositoryContract;
use PCForge\Models\GraphicsComponent;
use PCForge\Models\MotherboardComponent;

class GraphicsComponentCompatibilityProvider implements CompatibilityProvider
{
    /** @var ComponentRepositoryContract $components */
    private $components;

    public function __construct(ComponentRepositoryContract $componentRepo)
    {
        $this->components = $componentRepo;
    }

    public function getStaticallyCompatible($component): Collection
    {
        return collect($component->id);
    }

    public function getStaticallyIncompatible($component): Collection
    {
        return $this->components->withParent(GraphicsComponent::class)
            ->where('graphics_components.id', '!=', $component->id)
            ->pluck('components.id');
    }

    public function getDynamicallyCompatible($component, array $selection): Collection
    {
        return $this->components->withParent(MotherboardComponent::class)
            ->whereIn('components.id', array_keys($selection))
            ->where('pcie3_slots', '>=', $selection[$component->parent->id] ?? 0)
            ->pluck('components.id');
    }

    public function getDynamicallyIncompatible($component, array $selection): Collection
    {
        return $this->components->withParent(MotherboardComponent::class)
            ->whereIn('components.id', array_keys($selection))
            ->where('pcie3_slots', '<', $selection[$component->parent->id] ?? 0)
            ->pluck('components.id');
    }
}
