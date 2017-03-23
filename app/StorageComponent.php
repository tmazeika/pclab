<?php

namespace PCForge;

use Illuminate\Database\Eloquent\Model;

class StorageComponent extends Model
{
    use ComponentChild, Validatable;

    protected $fillable = [
        'id',
        'component_id',
        'capacity',
        'is_ssd',
        'size',
    ];

    private $createRules = [
        'id'              => 'nullable|integer|unique:storage_components|min:0',
        'component_id'    => 'required|exists:components,id',
        'capacity'        => 'required|integer|min:0',
        'is_ssd'          => 'required|boolean',
        'storage_size_id' => 'required|exists:storage_sizes,id',
    ];

    private $updateRules = [
        'id'              => 'nullable|integer|unique:storage_components|min:0',
        'component_id'    => 'nullable|exists:components,id',
        'capacity'        => 'nullable|integer|min:0',
        'is_ssd'          => 'nullable|boolean',
        'storage_size_id' => 'nullable|exists:storage_sizes,id',
    ];
}
