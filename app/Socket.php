<?php

namespace PCForge;

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
        'name' => 'required|string',
    ];

    private $updateRules = [
        'id'   => 'nullable|integer|unique:sockets|min:0',
        'name' => 'nullable|string',
    ];

    public function coolingComponents()
    {
        return $this->belongsToMany('PCForge\CoolingComponent');
    }

    public function motherboardComponents()
    {
        return $this->belongsToMany('PCForge\MotherboardComponent');
    }

    public function processorComponents()
    {
        return $this->belongsToMany('PCForge\ProcessorComponent');
    }
}
