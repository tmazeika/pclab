<?php

namespace PCForge;

use Illuminate\Database\Eloquent\Model;

class CoolingSocket extends Model
{
    use Validatable;

    protected $fillable = [
        'id',
        'cooling_component_id',
        'name',
    ];

    private $createRules = [
        'id'                   => 'nullable|integer|unique:cooling_sockets|min:0',
        'cooling_component_id' => 'required|exists:cooling_components,id',
        'name'                 => 'required|string',
    ];

    private $updateRules = [
        'id'                   => 'nullable|integer|unique:cooling_sockets|min:0',
        'cooling_component_id' => 'nullable|exists:cooling_components,id',
        'name'                 => 'nullable|string',
    ];

    public function coolingComponents()
    {
        return $this->belongsToMany('PCForge\CoolingComponent');
    }
}
