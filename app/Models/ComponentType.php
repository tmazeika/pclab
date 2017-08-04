<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property string name
 * @property bool is_allowed_multiple
 * @property bool is_always_required
 *
 * @property Collection components
 */
class ComponentType extends Model
{
    protected $fillable = [
        'name',
        'is_allowed_multiple',
        'is_always_required',
    ];

    public function components()
    {
        return $this->hasMany(Component::class);
    }
}
