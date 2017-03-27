<?php

namespace PCForge;

use Illuminate\Database\Eloquent\Model;

class FormFactor extends Model
{
    use Validatable;

    protected $fillable = [
        'id',
        'name',
    ];

    private $createRules = [
        'id'   => 'nullable|integer|unique:form_factors|min:0',
        'name' => 'required|string|unique:form_factors',
    ];

    private $updateRules = [
        'id'   => 'nullable|integer|unique:form_factors|min:0',
        'name' => 'nullable|string|unique:form_factors',
    ];

    public function chassis_components()
    {
        return $this->belongsToMany('PCForge\ChassisComponent');
    }

    public function motherboard_components()
    {
        return $this->belongsToMany('PCForge\MotherboardComponent');
    }
}
