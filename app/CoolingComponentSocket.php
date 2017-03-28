<?php

namespace PCForge;

use Illuminate\Database\Eloquent\Model;

class CoolingComponentSocket extends Model
{
    use Validatable;

    public $table = 'cooling_component_socket';
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

    public function cooling_component()
    {
        return $this->belongsTo('PCForge\CoolingComponent');
    }

    public function socket()
    {
        return $this->belongsTo('PCForge\Socket');
    }
}
