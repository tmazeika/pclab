<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;

class Socket extends PCForgeModel
{
    protected $fillable = [
        'name',
    ];

    public function cooling_components()
    {
        return $this->hasMany(CoolingComponent::class);
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
