<?php

namespace PCForge;

use Illuminate\Database\Eloquent\Model;

class StorageSize extends Model
{
    use Validatable;

    protected $fillable = [
        'id',
        'name',
    ];

    private $createRules = [
        'id'   => 'nullable|integer|unique:storage_sizes|min:0',
        'name' => 'required|string',
    ];

    private $updateRules = [
        'id'   => 'nullable|integer|unique:storage_sizes|min:0',
        'name' => 'nullable|string',
    ];
}
