<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property int chassis_component_id
 * @property int max_fan_width
 * @property int max_length
 *
 * @property ChassisComponent chassis_component
 */
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
