<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int minimum
 * @property int maximum
 *
 * @property Component component
 * @property ComponentType type
 */
class ComponentRequirement extends Model
{
    protected $fillable = [
        'component_id',
        'component_type_id',
        'minimum',
        'maximum',
    ];

    public function component()
    {
        return $this->belongsTo(Component::class);
    }

    public function type()
    {
        return $this->belongsTo(ComponentType::class, 'component_type_id');
    }
}
