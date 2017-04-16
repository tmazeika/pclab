<?php

namespace PCForge\Models;

class ChassisComponentsRadiator extends PCForgeModel
{
    protected $fillable = [
        'chassis_component_id',
        'max_fan_width',
        'max_length',
    ];

    public function chassis_component()
    {
        return $this->belongsTo(ChassisComponent::class);
    }
}
