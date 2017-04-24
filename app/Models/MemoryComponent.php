<?php

namespace PCForge\Models;

use PCForge\Compatibility\Providers\MemoryComponentCompatibilityProvider;
use PCForge\Presenters\MemoryComponentPresenter;

class MemoryComponent extends ComponentChild
{
    protected $fillable = [
        'count',
        'height',
        'capacity_each',
        'ddr_gen',
        'pins',
    ];

    protected $presenter = MemoryComponentPresenter::class;

    protected $compatibilityProvider = MemoryComponentCompatibilityProvider::class;
}
