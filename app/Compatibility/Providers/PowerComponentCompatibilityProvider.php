<?php

namespace PCForge\Compatibility\Providers;

use Illuminate\Support\Collection;
use PCForge\Contracts\ComponentRepositoryContract;
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

    /** @var ComponentRepositoryContract $components */
    private $components;

    public function __construct(ComponentRepositoryContract $componentRepo)
    {
        $this->components = $componentRepo;
    }

    public function getDynamicallyCompatible($component, array $selection): Collection
    {
        return collect();
    }

    public function getDynamicallyIncompatible($component, array $selection): Collection
    {
        // power
        $systemWattage = $this->computeSystemWattage($selection);

        if ($component->watts_out < $systemWattage) {
            $components[] = [
                Component
                    ::where('watts_usage', '>', 0)
                    ->pluck('id'),
                $component->component_id,
            ];
        } else {
            $components[] = Component
                ::where('watts_usage', '>', $component->watts_out - $systemWattage)
                ->pluck('id');
        }

        // storage
        $storageCount = $this->components->withParent(StorageComponent::class)
            ->whereIn('components.id', array_keys($selection))
            ->count();

        if ($storageCount === $component->sata_powers) {
            $components[] = $this->components->withParent(StorageComponent::class)
                ->whereNotIn('components.id', array_keys($selection))
                ->pluck('components.id');
        } else if ($storageCount > $component->sata_powers) {
            $components[] = $this->component_id;
        }

        return collect($components);
    }

    private function computeSystemWattage(array $selection): int
    {
        /** @var Collection $components */
        $components = Component::select('id', 'watts_usage')->whereIn('id', array_keys($selection))->get();

        $systemWattage = collect($selection)
            ->map(function (int $count, int $id) use ($components) {
                return $components->where('id', $id)->first()->watts_usage * $count;
            })
            ->sum();

        return ceil((float)($systemWattage + self::WATTS_BUFFER) / self::WATTS_INCREMENT) * self::WATTS_INCREMENT;
    }
}
