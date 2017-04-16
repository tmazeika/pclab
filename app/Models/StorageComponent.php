<?php

namespace PCForge\Models;

use PCForge\Presenters\StorageComponentPresenter;

class StorageComponent extends ComponentChild
{
    protected $fillable = [
        'component_id',
        'capacity',
        'is_ssd',
        'size',
    ];

    protected $presenter = StorageComponentPresenter::class;

    public function storage_size()
    {
        return $this->hasMany(StorageWidth::class);
    }
}
