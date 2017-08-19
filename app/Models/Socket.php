<?php

namespace PCLab\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property int id
 * @property string name
 *
 * @property Collection cooling_components
 * @property Collection motherboard_components
 * @property Collection processor_components
 */
class Socket extends Model
{
    public function cooling_components()
    {
        return $this->belongsToMany(CoolingComponent::class);
    }

    public function motherboard_components()
    {
        return $this->hasMany(MotherboardComponent::class);
    }

    public function processor_components()
    {
        return $this->hasMany(ProcessorComponent::class);
    }
}
