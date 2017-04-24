<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;

class StorageWidth extends Model
{
    public function storage_components()
    {
        return $this->hasMany(StorageComponent::class);
    }
}
