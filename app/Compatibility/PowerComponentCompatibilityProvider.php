<?php

namespace PCForge\Compatibility;

use Illuminate\Support\Collection;
use PCForge\Contracts\ComponentRepositoryContract;
use PCForge\Contracts\ComponentSelectionServiceContract;
use PCForge\Models\ChassisComponent;
use PCForge\Models\Component;
use PCForge\Models\MotherboardComponent;
use PCForge\Models\PowerComponent;
use PCForge\Models\StorageComponent;

class PowerComponentCompatibilityProvider implements CompatibilityProvider
{
    /** The computed system wattage should be reported in increments of this number. */
    private const WATTS_INCREMENT = 50;

    /** The least number of watts above the computed system wattage the power supply must be. */
    private const WATTS_BUFFER = 150;

    /** @var ComponentSelectionServiceContract $componentSelectionService */
    private $componentSelectionService;

    public function __construct(ComponentSelectionServiceContract $componentSelectionService)
    {
        $this->componentSelectionService = $componentSelectionService;
    }

    public function getStaticallyCompatible($component): Collection
    {
        // chassis
        return ChassisComponent::pluck('component_id')->flatten();
    }

    public function getStaticallyIncompatible($component): Collection
    {
        // motherboard
        $components[] = MotherboardComponent::where('atx12v_pins', '>', $component->atx12v_pins)->pluck('component_id');

        // power
        $components[] = PowerComponent::where('id', '!=', $component->id)->pluck('component_id');

        return collect($components)->flatten();
    }

    public function getDynamicallyCompatible($component): Collection
    {
        return collect();
    }

    public function getDynamicallyIncompatible($component): Collection
    {
        // power
        $systemWattage = $this->computeSystemWattage();

        if ($component->watts_out < $systemWattage) {
            $components[] = [
                $component->component_id,
                Component::where('watts_usage', '>', 0)->pluck('id'),
            ];
        } else {
            $components[] = Component::where('watts_usage', '>', $component->watts_out - $systemWattage)->pluck('id');
        }

        // storage
        $storageComponents = $this->componentSelectionService->allSelected(['id'], 'storage');
        $storageCount = $storageComponents->count();

        if ($storageCount === $component->sata_powers) {
            $components[] = StorageComponent::whereNotIn('component_id', $storageComponents->id)->pluck('component_id');
        } else if ($storageCount > $component->sata_powers) {
            $components[] = $this->component_id;
        }

        return collect($components)->flatten();
    }

    public function getComponentType(): string
    {
        return 'power';
    }

    private function computeSystemWattage(): int
    {
        $systemWattage = $this->componentSelectionService->all(['watts_usage'])->map(function (Component $component) {
                return $component->watts_usage * $component->count;
            })->sum() + self::WATTS_BUFFER;

        return ceil((float)$systemWattage / self::WATTS_INCREMENT) * self::WATTS_INCREMENT;
    }
}
