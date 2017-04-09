<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;

class Compatibility extends Model
{
    use ExtendedModel, Validatable;

    private const CREATE_RULES = [
        'component_1_id' => 'required|exists:components,id',
        'component_2_id' => 'required|exists:components,id',
    ];

    private const UPDATE_RULES = [
        'component_1_id' => 'nullable|exists:components,id',
        'component_2_id' => 'nullable|exists:components,id',
    ];

    public $timestamps = false;

    protected $fillable = [
        'component_1_id',
        'component_2_id',
    ];

    public function component_1()
    {
        return $this->belongsTo('PCForge\Models\Component');
    }

    public function component_2()
    {
        return $this->belongsTo('PCForge\Models\Component');
    }
}
