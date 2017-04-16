<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;

class FormFactor extends PCForgeModel
{
    protected $fillable = [
        'name',
    ];

    public function chassis_components()
    {
        return $this->belongsToMany(ChassisComponent::class);
    }

    public function motherboard_components()
    {
        return $this->belongsToMany(MotherboardComponent::class);
    }
}
