<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;

class CoolingComponentSocket extends Model
{
    use ExtendedModel, Validatable;

    private const CREATE_RULES = [
        'cooling_component_id' => 'required|exists:cooling_components,id',
        'socket_id'            => 'required|exists:sockets,id',
    ];

    private const UPDATE_RULES = [
        'cooling_component_id' => 'nullable|exists:cooling_components,id',
        'socket_id'            => 'nullable|exists:sockets,id',
    ];

    public $table = 'cooling_component_socket';

    public $timestamps = false;

    protected $fillable = [
        'cooling_component_id',
        'socket_id',
    ];

    public function cooling_component()
    {
        return $this->belongsTo('PCForge\Models\CoolingComponent');
    }

    public function socket()
    {
        return $this->belongsTo('PCForge\Models\Socket');
    }
}
