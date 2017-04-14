<?php

namespace PCForge\Models;

use Illuminate\Support\Collection;

class StorageComponent extends ComponentChild
{
    private const CREATE_RULES = [
        'id'               => 'nullable|integer|unique:storage_components|min:0',
        'component_id'     => 'required|exists:components,id|unique:storage_components',
        'capacity'         => 'required|integer|min:0',
        'is_ssd'           => 'required|boolean',
        'storage_width_id' => 'required|exists:storage_widths,id',
    ];

    private const UPDATE_RULES = [
        'id'               => 'nullable|integer|unique:storage_components|min:0',
        'component_id'     => 'nullable|exists:components,id|unique:storage_components',
        'capacity'         => 'nullable|integer|min:0',
        'is_ssd'           => 'nullable|boolean',
        'storage_width_id' => 'nullable|exists:storage_widths,id',
    ];

    protected $fillable = [
        'id',
        'component_id',
        'capacity',
        'is_ssd',
        'size',
    ];

    public function storage_size()
    {
        return $this->hasMany('PCForge\Models\StorageWidth');
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
