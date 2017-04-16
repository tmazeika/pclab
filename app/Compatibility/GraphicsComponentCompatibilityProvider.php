<?php

namespace PCForge\Compatibility;

use Illuminate\Support\Collection;
use PCForge\Contracts\ComponentRepositoryContract;
use PCForge\Contracts\ComponentSelectionServiceContract;
use PCForge\Models\GraphicsComponent;
use PCForge\Models\MotherboardComponent;

class GraphicsComponentCompatibilityProvider implements CompatibilityProvider
{
    /** @var ComponentSelectionServiceContract $componentSelectionService */
    private $componentSelectionService;

    public function __construct(ComponentSelectionServiceContract $componentSelectionService)
    {
        $this->componentSelectionService = $componentSelectionService;
    }

    public function getStaticallyCompatible($component): Collection
    {
        return collect([$component->id]);
    }

    public function getStaticallyIncompatible($component): Collection
    {
        // graphics
        return GraphicsComponent::where('id', '!=', $component->id)->pluck('component_id')->flatten();
    }

    public function getDynamicallyCompatible($component): Collection
    {
        // motherboard
        return MotherboardComponent
            ::whereIn('component_id', $this->componentSelectionService->allSelected())
            ->where('pcie3_slots', '>=', $this->componentSelectionService->getCount($component))
            ->pluck('component_id')
            ->flatten();
    }

    public function getDynamicallyIncompatible($component): Collection
    {
        // motherboard
        return MotherboardComponent
            ::whereIn('component_id', $this->componentSelectionService->allSelected())
            ->where('pcie3_slots', '<', $this->componentSelectionService->getCount($component))
            ->pluck('component_id')
            ->flatten();
    }

    public function getComponentType(): string
    {
        return 'graphics';
    }
}
