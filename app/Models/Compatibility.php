<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;

class Compatibility extends Model
{
    public $timestamps = false;

    use Validatable;

    protected $fillable = [
        'component_1_id',
        'component_2_id',
    ];

    private $createRules = [
        'component_1_id' => 'required|exists:components,id',
        'component_2_id' => 'required|exists:components,id',
    ];

    private $updateRules = [
        'component_1_id' => 'nullable|exists:components,id',
        'component_2_id' => 'nullable|exists:components,id',
    ];

    public function component_1()
    {
        return $this->belongsTo('PCForge\Models\Component', 'component_1_id', 'id');
    }

    public function component_2()
    {
        return $this->belongsTo('PCForge\Models\Component', 'component_2_id', 'id');
    }
}
