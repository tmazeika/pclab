<?php

namespace PCForge;

use Illuminate\Database\Eloquent\Model;

class ProcessorComponent extends Model
{
    use ComponentChild, Validatable;

    protected $fillable = [
        'id',
        'component_id',
        'has_apu',
        'socket',
        'speed',
    ];

    private $createRules = [
        'id'           => 'nullable|integer|unique:processor_components|min:0',
        'component_id' => 'required|exists:components,id',
        'has_apu'      => 'required|boolean',
        'socket'       => 'required|string',
        'speed'        => 'required|numeric|min:0',
    ];

    private $updateRules = [
        'id'           => 'nullable|integer|unique:processor_components|min:0',
        'component_id' => 'nullable|exists:components,id',
        'has_apu'      => 'nullable|boolean',
        'socket'       => 'nullable|string',
        'speed'        => 'nullable|numeric|min:0',
    ];
}
