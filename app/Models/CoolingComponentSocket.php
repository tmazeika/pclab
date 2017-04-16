<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;

class CoolingComponentSocket extends PCForgeModel
{
    public $table = 'cooling_component_socket';

    public $timestamps = false;

    protected $fillable = [
        'cooling_component_id',
        'socket_id',
    ];

    public function cooling_component()
    {
        return $this->belongsTo(CoolingComponent::class);
    }

    public function socket()
    {
        return $this->belongsTo(Socket::class);
    }
}
