<?php

namespace PCForge\Models;

class ComponentType extends PCForgeModel
{
    protected $fillable = [
        'name',
        'allows_multiple',
    ];

    public function components()
    {
        return $this->hasMany(Component::class);
    }
}
