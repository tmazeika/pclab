<?php

namespace PCForge\Models;

use PCForge\Compatibility\Providers\StorageComponentCompatibilityProvider;
use PCForge\Presenters\StorageComponentPresenter;

/**
 * @property int id
 * @property int capacity
 * @property bool is_ssd
 * @property int width
 */
class StorageComponent extends ComponentChild
{
    protected $fillable = [
        'capacity',
        'is_ssd',
        'width',
    ];

    protected $presenter = StorageComponentPresenter::class;

    protected $compatibilityProvider = StorageComponentCompatibilityProvider::class;
}
