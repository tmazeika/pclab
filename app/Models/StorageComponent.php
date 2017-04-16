<?php

namespace PCForge\Models;

use Illuminate\Support\Collection;

class StorageComponent extends ComponentChild
{
    protected $fillable = [
        'component_id',
        'capacity',
        'is_ssd',
        'size',
    ];

    protected $presenter = 'PCForge\Presenters\StorageComponentPresenter';

    public function storage_size()
    {
        return $this->hasMany(StorageWidth::class);
    }

    public function getStaticallyCompatibleComponents(): Collection
    {
        return collect($this->id);
    }

    public function getStaticallyIncompatibleComponents(): Collection
    {
        return collect();
    }

    public function getDynamicallyCompatibleComponents(array $selected): Collection
    {
        return collect();
    }

    public function getDynamicallyIncompatibleComponents(array $selected): Collection
    {
        return collect();
    }
}
