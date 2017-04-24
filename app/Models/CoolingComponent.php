<?php

namespace PCForge\Models;

use PCForge\Compatibility\Providers\CoolingComponentCompatibilityProvider;
use PCForge\Presenters\CoolingComponentPresenter;

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

    protected $compatibilityProvider = CoolingComponentCompatibilityProvider::class;

    public function sockets()
    {
        return $this->belongsToMany(Socket::class);
    }
}
