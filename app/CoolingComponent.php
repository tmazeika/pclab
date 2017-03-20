<?php

namespace PCForge;

use Illuminate\Database\Eloquent\Model;

class CoolingComponent extends Model
{
    use ComponentChild, Validatable;

    protected $fillable = [
        'id',
        'component_id',
        'is_air',
        'fan_size',
        'radiator_x',
        'radiator_z',
    ];

    private $createRules = [
        'id'           => 'nullable|integer|unique:cooling_components|min:0',
        'component_id' => 'required|exists:components,id',
        'is_air'       => 'required|boolean',
        'fan_size'     => 'required|integer|min:0',
        'radiator_x'   => 'required|integer|min:0',
        'radiator_z'   => 'required|integer|min:0',
    ];

    private $updateRules = [
        'id'           => 'nullable|integer|unique:cooling_components|min:0',
        'component_id' => 'nullable|exists:components,id',
        'is_air'       => 'nullable|boolean',
        'fan_size'     => 'nullable|integer|min:0',
        'radiator_x'   => 'nullable|integer|min:0',
        'radiator_z'   => 'nullable|integer|min:0',
    ];
}
