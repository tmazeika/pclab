<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;

class ComponentType extends Model
{
    use Validatable;

    protected $fillable = [
        'id',
        'name',
    ];

    private $createRules = [
        'id'   => 'nullable|integer|unique:component_types|min:0',
        'name' => 'required|string|unique:component_types',
    ];

    private $updateRules = [
        'id'   => 'nullable|integer|unique:component_types|min:0',
        'name' => 'nullable|string|unique:component_types',
    ];

    public function components()
    {
        return $this->hasMany('PCForge\Models\Component');
    }
}
