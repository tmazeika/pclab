<?php

namespace PCForge;

use Illuminate\Database\Eloquent\Model;

class StorageComponent extends Model
{
    use ComponentChild, Validatable;

    protected $fillable = [
        'id',
        'component_id',
        'size',
    ];

    private $createRules = [
        'id'           => 'nullable|integer|unique:storage_components|min:0',
        'component_id' => 'required|exists:components,id',
        'size'         => 'required|integer|min:0',
    ];

    private $updateRules = [
        'id'           => 'nullable|integer|unique:storage_components|min:0',
        'component_id' => 'nullable|exists:components,id',
        'size'         => 'nullable|integer|min:0',
    ];
}
