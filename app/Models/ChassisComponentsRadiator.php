<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;

class ChassisComponentsRadiator extends Model
{
    use ExtendedModel, Validatable;

    private const CREATE_RULES = [
        'id'                   => 'nullable|integer|unique:chassis_components_radiators|min:0',
        'chassis_component_id' => 'required|exists:chassis_components,id',
        'max_fan_width'        => 'required|integer|min:0',
        'max_length'           => 'required|integer|min:0',
    ];

    private const UPDATE_RULES = [
        'id'                   => 'nullable|integer|unique:chassis_components_radiators|min:0',
        'chassis_component_id' => 'nullable|exists:chassis_components,id',
        'max_fan_width'        => 'nullable|integer|min:0',
        'max_length'           => 'nullable|integer|min:0',
    ];

    protected $fillable = [
        'id',
        'chassis_component_id',
        'max_fan_width',
        'max_length',
    ];

    public function chassis_component()
    {
        return $this->belongsTo('PCForge\Models\ChassisComponent');
    }
}
