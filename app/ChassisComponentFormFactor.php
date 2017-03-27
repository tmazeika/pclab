<?php

namespace PCForge;

use Illuminate\Database\Eloquent\Model;

class ChassisComponentFormFactor extends Model
{
    use Validatable;

    public $timestamps = false;

    protected $fillable = [
        'chassis_component_id',
        'form_factor_id',
    ];

    private $createRules = [
        'chassis_component_id' => 'required|exists:chassis_components,id',
        'form_factor_id'       => 'required|exists:form_factors,id',
    ];

    private $updateRules = [
        'chassis_component_id' => 'nullable|exists:chassis_components,id',
        'form_factor_id'       => 'nullable|exists:form_factors,id',
    ];

    public function chassis_component()
    {
        return $this->hasOne('PCForge\ChassisComponent');
    }

    public function form_factors()
    {
        return $this->hasOne('PCForge\FormFactor');
    }
}
