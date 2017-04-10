<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;

class ComponentType extends Model
{
    use ExtendedModel, Validatable;

    private const CREATE_RULES = [
        'id'                          => 'nullable|integer|unique:component_types|min:0',
        'name'                        => 'required|string|unique:component_types',
        'allows_multiple'             => 'required|boolean',
    ];

    private const UPDATE_RULES = [
        'id'                          => 'nullable|integer|unique:component_types|min:0',
        'name'                        => 'nullable|string|unique:component_types',
        'allows_multiple'             => 'nullable|boolean',
    ];

    protected $fillable = [
        'id',
        'name',
        'allows_multiple',
    ];

    public function components()
    {
        return $this->hasMany('PCForge\Models\Component');
    }
}
