<?php

namespace PCForge\Models;

use Illuminate\Support\Collection;

class MemoryComponent extends ComponentChild
{
    protected $fillable = [
        'component_id',
        'count',
        'height',
        'capacity_each',
        'ddr_gen',
        'pins',
    ];

    protected $presenter = 'PCForge\Presenters\MemoryComponentPresenter';

    public function getStaticallyCompatibleComponents(): Collection
    {
        // motherboard
        return MotherboardComponent
            ::where('dimm_gen', $this->ddr_gen)
            ->where('dimm_pins', $this->pins)
            ->pluck('component_id')
            ->flatten();
    }

    public function getStaticallyIncompatibleComponents(): Collection
    {
        // cooling
        $components[] = CoolingComponent
            ::where('max_memory_height', '<', $this->height)
            ->pluck('component_id');

        // memory
        $components[] = MemoryComponent
            ::where('id', '!=', $this->id)
            ->pluck('component_id');

        // motherboard
        $components[] = MotherboardComponent
            ::where('dimm_gen', '!=', $this->ddr_gen)
            ->orWhere('dimm_pins', '!=', $this->pins)
            ->pluck('component_id');

        return collect($components)->flatten();
    }

    public function getDynamicallyCompatibleComponents(array $selected): Collection
    {
        return collect();
    }

    public function getDynamicallyIncompatibleComponents(array $selected): Collection
    {
        return collect();
    }
}
