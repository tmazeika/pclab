<?php

namespace PCForge\Models;

use PCForge\Presenters\MemoryComponentPresenter;

/**
 * @property int id
 * @property int count
 * @property int height
 * @property int capacity_each
 * @property int ddr_gen
 * @property int pins
 */
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
}
