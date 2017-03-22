<?php

namespace PCForge;

use Illuminate\Database\Eloquent\Model;

class ChassisComponentsRadiator extends Model
{
    use Validatable;

    protected $fillable = [
        'id',
        'chassis_component_id',
        'is_max_absolute',
        'max_size_x',
        'fan_size_xz',
    ];

    private $createRules = [
        'id'                   => 'nullable|integer|unique:chassis_components_radiators|min:0',
        'chassis_component_id' => 'required|exists:chassis_components,id',
        'is_max_absolute'      => 'required|boolean',
        'max_size_x'           => 'required|integer|min:0',
        'fan_size_xz'          => 'required|integer|min:0',
    ];

    private $updateRules = [
        'id'                   => 'nullable|integer|unique:chassis_components_radiators|min:0',
        'chassis_component_id' => 'nullable|exists:chassis_components,id',
        'is_max_absolute'      => 'nullable|boolean',
        'max_size_x'           => 'nullable|integer|min:0',
        'fan_size_xz'          => 'nullable|integer|min:0',
    ];

    public function chassisComponent()
    {
        return $this->belongsTo('PCForge\ChassisComponent');
    }
}
