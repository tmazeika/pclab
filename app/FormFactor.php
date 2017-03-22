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
        'name' => 'required|string',
    ];

    private $updateRules = [
        'id'   => 'nullable|integer|unique:form_factors|min:0',
        'name' => 'nullable|string',
    ];

    public function chassisComponents()
    {
        return $this->belongsToMany('PCForge\ChassisComponent');
    }

    public function motherboardComponents()
    {
        return $this->belongsToMany('PCForge\MotherboardComponent');
    }
}
