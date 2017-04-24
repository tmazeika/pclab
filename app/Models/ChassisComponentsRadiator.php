<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;

class ChassisComponentsRadiator extends Model
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
