<?php

namespace PCForge\Models;

class ChassisComponentFormFactor extends PCForgeModel
{
    public $table = 'chassis_component_form_factor';

    public $timestamps = false;

    protected $fillable = [
        'chassis_component_id',
        'form_factor_id',
    ];

    public function chassis_component()
    {
        return $this->belongsTo(ChassisComponent::class);
    }

    public function form_factors()
    {
        return $this->belongsTo(FormFactor::class);
    }
}
