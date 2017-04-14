<?php

namespace PCForge\Models;

use Illuminate\Support\Collection;

class MemoryComponent extends ComponentChild
{
    private const CREATE_RULES = [
        'id'            => 'nullable|integer|unique:memory_components|min:0',
        'component_id'  => 'required|exists:components,id|unique:memory_components',
        'count'         => 'required|integer|min:0',
        'height'        => 'required|integer|min:0',
        'capacity_each' => 'required|integer|min:0',
        'ddr_gen'       => 'required|integer|min:0',
        'pins'          => 'required|integer|min:0',
    ];

    private const UPDATE_RULES = [
        'id'            => 'nullable|integer|unique:memory_components|min:0',
        'component_id'  => 'nullable|exists:components,id|unique:memory_components',
        'count'         => 'nullable|integer|min:0',
        'height'        => 'nullable|integer|min:0',
        'capacity_each' => 'nullable|integer|min:0',
        'ddr_gen'       => 'nullable|integer|min:0',
        'pins'          => 'nullable|integer|min:0',
    ];

    protected $fillable = [
        'id',
        'component_id',
        'count',
        'height',
        'capacity_each',
        'ddr_gen',
        'pins',
    ];

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
