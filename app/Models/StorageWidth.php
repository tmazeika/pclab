<?php

namespace PCForge\Models;

class StorageWidth extends PCForgeModel
{
    protected $fillable = [
        'name',
    ];

    public function storage_components()
    {
        return $this->hasMany(StorageComponent::class);
    }
}
