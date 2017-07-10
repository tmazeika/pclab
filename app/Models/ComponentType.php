<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property Collection components
 */
class ComponentType extends Model
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
