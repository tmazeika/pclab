<?php

namespace PCForge;

use Illuminate\Database\Eloquent\Model;

class ChassisRadiator extends Model
{
    use ComponentChild, Validatable;

    protected $fillable = [
        'id',
        'chassis_component_id',
        'is_max_absolute',
        'max_size_x',
        'fan_size_xz',
    ];

    private $createRules = [
        'id'                   => 'nullable|integer|unique:chassis_form_factors|min:0',
        'chassis_component_id' => 'required|exists:chassis_components,id',
        'is_max_absolute'      => 'required|boolean',
        'max_size_x'           => 'required|integer|min:0',
        'fan_size_xz'          => 'required|integer|min:0',
    ];

    public function chassis()
    {
        return $this->belongsToMany('PCForge\ChassisComponent');
    }
}
