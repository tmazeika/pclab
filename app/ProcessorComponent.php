<?php

namespace PCForge;

use Illuminate\Database\Eloquent\Model;

class ProcessorComponent extends Model
{
    use ComponentChild, Validatable;

    protected $fillable = [
        'id',
        'component_id',
        'cores',
        'has_apu',
        'has_stock_cooler',
        'socket_id',
        'speed',
    ];

    private $createRules = [
        'id'               => 'nullable|integer|unique:processor_components|min:0',
        'component_id'     => 'required|exists:components,id|unique:processor_components',
        'cores'            => 'required|integer|min:0',
        'has_apu'          => 'required|boolean',
        'has_stock_cooler' => 'required|boolean',
        'socket_id'        => 'required|exists:sockets,id',
        'speed'            => 'required|integer|min:0',
    ];

    private $updateRules = [
        'id'               => 'nullable|integer|unique:processor_components|min:0',
        'component_id'     => 'nullable|exists:components,id|unique:processor_components',
        'cores'            => 'nullable|integer|min:0',
        'has_apu'          => 'nullable|boolean',
        'has_stock_cooler' => 'nullable|boolean',
        'socket_id'        => 'nullable|exists:sockets,id',
        'speed'            => 'nullable|integer|min:0',
    ];

    public function socket()
    {
        return $this->belongsTo('PCForge\Socket');
    }
}
