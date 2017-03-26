<?php

namespace PCForge;

use Illuminate\Database\Eloquent\Model;

class CoolingComponent extends Model
{
    use ComponentChild, Validatable;

    protected $fillable = [
        'id',
        'component_id',
        'is_air',
        'fan_width',
        'radiator_length',
        'max_memory_height',
    ];

    private $createRules = [
        'id'                => 'nullable|integer|unique:cooling_components|min:0',
        'component_id'      => 'required|exists:components,id|unique:cooling_components',
        'is_air'            => 'required|boolean',
        'fan_width'         => 'required|integer|min:0',
        'radiator_length'   => 'required|integer|min:0',
        'max_memory_height' => 'required|integer|min:0',
    ];

    private $updateRules = [
        'id'                => 'nullable|integer|unique:cooling_components|min:0',
        'component_id'      => 'nullable|exists:components,id|unique:cooling_components',
        'is_air'            => 'nullable|boolean',
        'fan_width'         => 'nullable|integer|min:0',
        'radiator_length'   => 'nullable|integer|min:0',
        'max_memory_height' => 'nullable|integer|min:0',
    ];

    public function sockets()
    {
        return $this->hasMany('PCForge\Socket');
    }
}
