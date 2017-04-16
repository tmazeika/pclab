<?php

namespace PCForge\Models;

use PCForge\Presenters\CoolingComponentPresenter;

class CoolingComponent extends ComponentChild
{
    protected $fillable = [
        'component_id',
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
}
