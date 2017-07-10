<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property int cooling_component_id
 * @property int socket_id
 *
 * @property CoolingComponent cooling_component
 * @property Socket socket
 */
class CoolingComponentSocket extends Model
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
