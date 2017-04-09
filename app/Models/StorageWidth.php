<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;

class StorageWidth extends Model
{
    use ExtendedModel, Validatable;

    private const CREATE_RULES = [
        'id'   => 'nullable|integer|unique:storage_widths|min:0',
        'name' => 'required|string|unique:storage_widths',
    ];

    private const UPDATE_RULES = [
        'id'   => 'nullable|integer|unique:storage_widths|min:0',
        'name' => 'nullable|string|unique:storage_widths',
    ];

    protected $fillable = [
        'id',
        'name',
    ];

    public function storage_components()
    {
        return $this->hasMany('PCForge\Models\StorageComponent');
    }
}
