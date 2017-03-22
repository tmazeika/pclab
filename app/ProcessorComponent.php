<?php

namespace PCForge;

use Illuminate\Database\Eloquent\Model;

class ProcessorComponent extends Model
{
    use ComponentChild, Validatable;

    protected $fillable = [
        'id',
        'component_id',
        'has_apu',
        'socket_id',
        'speed',
    ];

    private $createRules = [
        'id'           => 'nullable|integer|unique:processor_components|min:0',
        'component_id' => 'required|exists:components,id',
        'has_apu'      => 'required|boolean',
        'socket_id'    => 'required|exists:sockets,id',
        'speed'        => 'required|numeric|min:0',
    ];

    private $updateRules = [
        'id'           => 'nullable|integer|unique:processor_components|min:0',
        'component_id' => 'nullable|exists:components,id',
        'has_apu'      => 'nullable|boolean',
        'socket_id'    => 'nullable|exists:sockets,id',
        'speed'        => 'nullable|numeric|min:0',
    ];

    public function socket()
    {
        return $this->hasOne('PCForge\Socket');
    }
}
