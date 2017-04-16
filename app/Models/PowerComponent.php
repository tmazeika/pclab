<?php

namespace PCForge\Models;

use Illuminate\Support\Collection;

class PowerComponent extends ComponentChild
{
    const WATTS_INC = 50;

    protected $fillable = [
        'component_id',
        'atx12v_pins',
        'sata_powers',
        'is_modular',
        'watts_out',
    ];

    protected $presenter = 'PCForge\Presenters\PowerComponentPresenter';

    public function getStaticallyCompatibleComponents(): Collection
    {
        // chassis
        return ChassisComponent::pluck('component_id')->flatten();
    }

    public function getStaticallyIncompatibleComponents(): Collection
    {
        // motherboard
        $components[] = MotherboardComponent::where('atx12v_pins', '>', $this->atx12v_pins)->pluck('component_id');

        // power
        $components[] = PowerComponent::where('id', '!=', $this->id)->pluck('component_id');

        return collect($components)->flatten();
    }

    public function getDynamicallyCompatibleComponents(array $selected): Collection
    {
        return collect();
    }

    public function getDynamicallyIncompatibleComponents(array $selected): Collection
    {
        // power
        $systemWattsUsage = $this->getSystemWattsUsage($selected);

        if ($this->watts_out < $systemWattsUsage) {
            $components[] = [Component::where('watts_usage', '>', 0)->pluck('id'), $this->component_id];
        } else {
            $components[] = Component::where('watts_usage', '>', $this->watts_out - $systemWattsUsage)->pluck('id');
        }

        // storage
        $storageCount = StorageComponent::whereIn('component_id', array_keys($selected))->count();

        if ($storageCount === $this->sata_powers) {
            $components[] = StorageComponent::whereNotIn('component_id', array_keys($selected))->pluck('component_id');
        } else if ($storageCount > $this->sata_powers) {
            $components[] = $this->component_id;
        }

        return collect($components)->flatten();
    }

    private function getSystemWattsUsage(array $selected): int
    {
        $totalWattsUsage = 150;
        $selectedComponents = Component::whereIn('id', array_keys($selected))->pluck('watts_usage', 'id');

        foreach ($selectedComponents as $id => $wattsUsage) {
            $count = $selected[$id];
            $totalWattsUsage += $wattsUsage * $count;
        }

        // ceil total watts usage to next increment of 50
        return ceil((float)$totalWattsUsage / self::WATTS_INC) * self::WATTS_INC;
    }
}
