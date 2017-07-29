<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use PCForge\Presenters\CoolingComponentPresenter;

/**
 * @property int id
 * @property bool is_air
 * @property int fan_width
 * @property int height
 * @property int max_memory_height
 * @property int radiator_length
 *
 * @property Collection sockets
 */
class CoolingComponent extends ComponentChild
{
    protected $fillable = [
        'is_air',
        'fan_width',
        'height',
        'max_memory_height',
        'radiator_length',
    ];

    protected $presenter = CoolingComponentPresenter::class;

    public function sockets()
    {
        return $this->belongsToMany(Socket::class);
    }

    public function scopeWithAll(Builder $query): void
    {
        parent::scopeWithAll($query);

        $query->with('sockets');
    }
}
