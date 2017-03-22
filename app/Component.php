<?php

namespace PCForge;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use Validatable;

    protected $fillable = [
        'id',
        'asin',
        'name',
        'watts_usage',
        'weight',
    ];

    private $createRules = [
        'id'          => 'nullable|integer|unique:components|min:0',
        'asin'        => 'required|string',
        'name'        => 'required|string',
        'watts_usage' => 'required|integer|min:0',
        'weight'      => 'required|integer|min:0',
    ];

    private $updateRules = [
        'id'          => 'nullable|integer|unique:components|min:0',
        'asin'        => 'nullable|string',
        'name'        => 'nullable|string',
        'watts_usage' => 'nullable|integer|min:0',
        'weight'      => 'nullable|numeric|min:0',
    ];
}
