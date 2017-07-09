<?php

namespace PCForge\Models;

use PCForge\Compatibility\Providers\StorageComponentCompatibilityProvider;
use PCForge\Presenters\StorageComponentPresenter;

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
