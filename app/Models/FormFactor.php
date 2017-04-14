<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;

class FormFactor extends PCForgeModel
{
    private const CREATE_RULES = [
        'id'   => 'nullable|integer|unique:form_factors|min:0',
        'name' => 'required|string|unique:form_factors',
    ];

    private const UPDATE_RULES = [
        'id'   => 'nullable|integer|unique:form_factors|min:0',
        'name' => 'nullable|string|unique:form_factors',
    ];

    protected $fillable = [
        'id',
        'name',
    ];

    public function chassis_components()
    {
        return $this->belongsToMany('PCForge\Models\ChassisComponent');
    }

    public function motherboard_components()
    {
        return $this->belongsToMany('PCForge\Models\MotherboardComponent');
    }
}
