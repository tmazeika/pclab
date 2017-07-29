<?php

namespace PCForge\Models;

use PCForge\Presenters\StorageComponentPresenter;

/**
 * @property int id
 * @property int capacity
 * @property bool is_ssd
 * @property string width
 */
class StorageComponent extends ComponentChild
{
    protected $fillable = [
        'capacity',
        'is_ssd',
        'width',
    ];

    protected $presenter = StorageComponentPresenter::class;
}
