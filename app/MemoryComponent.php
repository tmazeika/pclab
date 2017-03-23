<?php

namespace PCForge;

use Illuminate\Database\Eloquent\Model;

class MemoryComponent extends Model
{
    use ComponentChild, Validatable;

    protected $fillable = [
        'id',
        'component_id',
        'size_z',
        'capacity',
        'ddr_gen',
        'pins',
    ];

    private $createRules = [
        'id'           => 'nullable|integer|unique:memory_components|min:0',
        'component_id' => 'required|exists:components,id',
        'size_z'       => 'required|integer|min:0',
        'capacity'     => 'required|integer|min:0',
        'ddr_gen'      => 'required|integer|min:0',
        'pins'         => 'required|integer|min:0',
    ];

    private $updateRules = [
        'id'           => 'nullable|integer|unique:memory_components|min:0',
        'component_id' => 'nullable|exists:components,id',
        'size_z'       => 'nullable|integer|min:0',
        'capacity'     => 'nullable|integer|min:0',
        'ddr_gen'      => 'nullable|integer|min:0',
        'pins'         => 'nullable|integer|min:0',
    ];
}
