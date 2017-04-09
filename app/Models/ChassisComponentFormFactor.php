<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;

class ChassisComponentFormFactor extends Model
{
    use ExtendedModel, Validatable;

    private const CREATE_RULES = [
        'chassis_component_id' => 'required|exists:chassis_components,id',
        'form_factor_id'       => 'required|exists:form_factors,id',
    ];

    private const UPDATE_RULES = [
        'chassis_component_id' => 'nullable|exists:chassis_components,id',
        'form_factor_id'       => 'nullable|exists:form_factors,id',
    ];

    public $table = 'chassis_component_form_factor';

    public $timestamps = false;

    protected $fillable = [
        'chassis_component_id',
        'form_factor_id',
    ];

    public function chassis_component()
    {
        return $this->belongsTo('PCForge\Models\ChassisComponent');
    }

    public function form_factors()
    {
        return $this->belongsTo('PCForge\Models\FormFactor');
    }
}
