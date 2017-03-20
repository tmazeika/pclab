<?php

namespace PCForge;

use Illuminate\Database\Eloquent\Model;

class PowerComponent extends Model
{
    use ComponentChild, Validatable;

    protected $fillable = [
        'id',
        'component_id',
        'atx12v_pins',
        'molexes',
        'sata_powers',
        'efficiency',
        'is_modular',
        'watts_out',
    ];

    private $createRules = [
        'id'           => 'nullable|integer|unique:power_components|min:0',
        'component_id' => 'required|exists:components,id',
        'atx12v_pins'  => 'required|integer|min:0',
        'molexes'      => 'required|integer|min:0',
        'sata_powers'  => 'required|integer|min:0',
        'efficiency'   => 'required|numeric|min:0|max:1',
        'is_modular'   => 'required|boolean',
        'watts_out'    => 'required|integer|min:0',
    ];

    private $updateRules = [
        'id'           => 'nullable|integer|unique:power_components|min:0',
        'component_id' => 'nullable|exists:components,id',
        'atx12v_pins'  => 'nullable|integer|min:0',
        'molexes'      => 'nullable|integer|min:0',
        'sata_powers'  => 'nullable|integer|min:0',
        'efficiency'   => 'nullable|numeric|min:0|max:1',
        'is_modular'   => 'nullable|boolean',
        'watts_out'    => 'nullable|integer|min:0',
    ];
}
