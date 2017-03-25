<?php

namespace PCForge;

use Illuminate\Database\Eloquent\Model;

class StorageWidth extends Model
{
    use Validatable;

    protected $fillable = [
        'id',
        'name',
    ];

    private $createRules = [
        'id'   => 'nullable|integer|unique:storage_widths|min:0',
        'name' => 'required|string',
    ];

    private $updateRules = [
        'id'   => 'nullable|integer|unique:storage_widths|min:0',
        'name' => 'nullable|string',
    ];

    public function storageComponents()
    {
        return $this->belongsToMany('PCForge\StorageComponent');
    }
}
