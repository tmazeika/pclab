<?php

namespace PCForge;

use Illuminate\Database\Eloquent\Model;

class ChassisFormFactor extends Model
{
    use ComponentChild, Validatable;

    protected $fillable = [
        'id',
        'chassis_component_id',
        'name',
    ];

    private $createRules = [
        'id'                   => 'nullable|integer|unique:chassis_form_factors|min:0',
        'chassis_component_id' => 'required|exists:chassis_components,id',
        'name'                 => 'required|string',
    ];

    public function chassis()
    {
        return $this->belongsToMany('PCForge\ChassisComponent');
    }
}
