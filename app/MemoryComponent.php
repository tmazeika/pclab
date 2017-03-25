<?php

namespace PCForge;

use Illuminate\Database\Eloquent\Model;

class MemoryComponent extends Model
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
        'component_id'  => 'required|exists:components,id',
        'count'         => 'required|integer|min:0',
        'height'        => 'required|integer|min:0',
        'capacity_each' => 'required|integer|min:0',
        'ddr_gen'       => 'required|integer|min:0',
        'pins'          => 'required|integer|min:0',
    ];

    private $updateRules = [
        'id'            => 'nullable|integer|unique:memory_components|min:0',
        'component_id'  => 'nullable|exists:components,id',
        'count'         => 'nullable|integer|min:0',
        'height'        => 'nullable|integer|min:0',
        'capacity_each' => 'nullable|integer|min:0',
        'ddr_gen'       => 'nullable|integer|min:0',
        'pins'          => 'nullable|integer|min:0',
    ];
}
