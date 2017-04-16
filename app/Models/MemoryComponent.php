<?php

namespace PCForge\Models;

use PCForge\Presenters\MemoryComponentPresenter;

class MemoryComponent extends ComponentChild
{
    protected $fillable = [
        'component_id',
        'count',
        'height',
        'capacity_each',
        'ddr_gen',
        'pins',
    ];

    protected $presenter = MemoryComponentPresenter::class;
}
