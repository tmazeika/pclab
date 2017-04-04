<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;

class Socket extends Model
{
    use Validatable;

    protected $fillable = [
        'id',
        'name',
    ];

    private $createRules = [
        'id'   => 'nullable|integer|unique:sockets|min:0',
        'name' => 'required|string|unique:sockets',
    ];

    private $updateRules = [
        'id'   => 'nullable|integer|unique:sockets|min:0',
        'name' => 'nullable|string|unique:sockets',
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
