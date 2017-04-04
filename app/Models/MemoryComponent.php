<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;

class MemoryComponent extends Model implements CompatibilityNode
{
    use ComponentChild, Validatable;

    protected $fillable = [
        'id',
        'component_id',
        'count',
        'height',
        'capacity_each',
        'ddr_gen',
        'pins',
    ];

    private $createRules = [
        'id'            => 'nullable|integer|unique:memory_components|min:0',
        'component_id'  => 'required|exists:components,id|unique:memory_components',
        'count'         => 'required|integer|min:0',
        'height'        => 'required|integer|min:0',
        'capacity_each' => 'required|integer|min:0',
        'ddr_gen'       => 'required|integer|min:0',
        'pins'          => 'required|integer|min:0',
    ];

    private $updateRules = [
        'id'            => 'nullable|integer|unique:memory_components|min:0',
        'component_id'  => 'nullable|exists:components,id|unique:memory_components',
        'count'         => 'nullable|integer|min:0',
        'height'        => 'nullable|integer|min:0',
        'capacity_each' => 'nullable|integer|min:0',
        'ddr_gen'       => 'nullable|integer|min:0',
        'pins'          => 'nullable|integer|min:0',
    ];

    public function getAllDirectlyCompatibleComponents(): array
    {
        // motherboard
        $components[] = MotherboardComponent
            ::where('dimm_gen', $this->ddr_gen)
            ->where('dimm_pins', $this->pins)
            ->pluck('component_id')
            ->all();

        return array_merge(...$components);
    }

    public function getAllDirectlyIncompatibleComponents(): array
    {
        // cooling
        $components[] = CoolingComponent
            ::where('max_memory_height', '<', $this->height)
            ->pluck('component_id')
            ->all();

        // memory
        $components[] = MemoryComponent
            ::where('id', '!=', $this->id)
            ->pluck('component_id')
            ->all();

        // motherboard
        $components[] = MotherboardComponent
            ::where('dimm_gen', '!=', $this->ddr_gen)
            ->orWhere('dimm_pins', '!=', $this->pins)
            ->pluck('component_id')
            ->all();

        return array_merge(...$components);
    }
}
