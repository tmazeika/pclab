<?php

namespace PCForge;

use Illuminate\Database\Eloquent\Model;

class MemoryComponent extends Model
{
    use ComponentChild, Validatable;

    protected $fillable = [
        'id',
        'component_id',
        'ddr_gen',
        'frequency',
        'pins',
        'size',
    ];

    private $createRules = [
        'id'           => 'nullable|integer|unique:memory_components|min:0',
        'component_id' => 'required|exists:components,id',
        'ddr_gen'      => 'required|integer|min:0',
        'frequency'    => 'required|integer|min:0',
        'pins'         => 'required|integer|min:0',
        'size'         => 'required|integer|min:0',
    ];

    private $updateRules = [
        'id'           => 'nullable|integer|unique:memory_components|min:0',
        'component_id' => 'nullable|exists:components,id',
        'ddr_gen'      => 'nullable|integer|min:0',
        'frequency'    => 'nullable|integer|min:0',
        'pins'         => 'nullable|integer|min:0',
        'size'         => 'nullable|integer|min:0',
    ];
}
