<?php

namespace PCForge;

use Illuminate\Database\Eloquent\Model;

class ChassisComponentsRadiator extends Model
{
    use Validatable;

    protected $fillable = [
        'id',
        'chassis_component_id',
        'max_fan_width',
        'max_length',
    ];

    private $createRules = [
        'id'                   => 'nullable|integer|unique:chassis_components_radiators|min:0',
        'chassis_component_id' => 'required|exists:chassis_components,id',
        'max_fan_width'        => 'required|integer|min:0',
        'max_length'           => 'required|integer|min:0',
    ];

    private $updateRules = [
        'id'                   => 'nullable|integer|unique:chassis_components_radiators|min:0',
        'chassis_component_id' => 'nullable|exists:chassis_components,id',
        'max_fan_width'        => 'nullable|integer|min:0',
        'max_length'           => 'nullable|integer|min:0',
    ];

    public function chassisComponent()
    {
        return $this->belongsTo('PCForge\ChassisComponent');
    }
}
