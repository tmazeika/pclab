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
        'fan_xy',
        'fan_z',
        'radiator_x',
        'radiator_z',
        'max_memory_z',
    ];

    private $createRules = [
        'id'           => 'nullable|integer|unique:cooling_components|min:0',
        'component_id' => 'required|exists:components,id',
        'is_air'       => 'required|boolean',
        'fan_xy'       => 'required|integer|min:0',
        'fan_z'        => 'required|integer|min:0',
        'radiator_x'   => 'required|integer|min:0',
        'radiator_z'   => 'required|integer|min:0',
    ];

    private $updateRules = [
        'id'           => 'nullable|integer|unique:cooling_components|min:0',
        'component_id' => 'nullable|exists:components,id',
        'is_air'       => 'nullable|boolean',
        'fan_xy'       => 'nullable|integer|min:0',
        'fan_z'        => 'nullable|integer|min:0',
        'radiator_x'   => 'nullable|integer|min:0',
        'radiator_z'   => 'nullable|integer|min:0',
    ];

    public function sockets()
    {
        return $this->hasMany('PCForge\Socket');
    }
}
