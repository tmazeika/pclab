<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property int id
 *
 * @property Collection chassis_components
 * @property Collection motherboard_components
 */
class FormFactor extends Model
{
    public function chassis_components()
    {
        return $this->belongsToMany(ChassisComponent::class);
    }

    public function motherboard_components()
    {
        return $this->hasMany(MotherboardComponent::class);
    }
}
