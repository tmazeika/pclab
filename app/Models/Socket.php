<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;

class Socket extends PCForgeModel
{
    private const CREATE_RULES = [
        'id'   => 'nullable|integer|unique:sockets|min:0',
        'name' => 'required|string|unique:sockets',
    ];

    private const UPDATE_RULES = [
        'id'   => 'nullable|integer|unique:sockets|min:0',
        'name' => 'nullable|string|unique:sockets',
    ];

    protected $fillable = [
        'id',
        'name',
    ];

    public function cooling_components()
    {
        return $this->hasMany('PCForge\Models\CoolingComponent');
    }

    public function motherboard_components()
    {
        return $this->hasMany('PCForge\Models\MotherboardComponent');
    }

    public function processor_components()
    {
        return $this->hasMany('PCForge\Models\ProcessorComponent');
    }
}
