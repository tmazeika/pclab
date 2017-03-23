<?php

namespace PCForge;

use Illuminate\Database\Eloquent\Model;

class CoolingComponentsSocket extends Model
{
    use Validatable;

    public $timestamps = false;

    protected $fillable = [
        'cooling_component_id',
        'socket_id',
    ];

    private $createRules = [
        'cooling_component_id' => 'required|exists:cooling_components,id',
        'socket_id'            => 'required|exists:sockets,id',
    ];

    private $updateRules = [
        'cooling_component_id' => 'nullable|exists:cooling_components,id',
        'socket_id'            => 'nullable|exists:sockets,id',
    ];
}
