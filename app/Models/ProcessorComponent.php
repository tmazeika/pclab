<?php

namespace PCForge\Models;

use PCForge\Compatibility\Providers\ProcessorComponentCompatibilityProvider;
use PCForge\Presenters\ProcessorComponentPresenter;

/**
 * @property int id
 * @property int cores
 * @property bool has_apu
 * @property bool has_stock_cooler
 * @property int speed
 * @property int socket_id
 *
 * @property Socket socket
 */
class ProcessorComponent extends ComponentChild
{
    protected $fillable = [
        'cores',
        'has_apu',
        'has_stock_cooler',
        'socket_id',
        'speed',
    ];

    protected $presenter = ProcessorComponentPresenter::class;

    protected $compatibilityProvider = ProcessorComponentCompatibilityProvider::class;

    public function socket()
    {
        return $this->belongsTo(Socket::class);
    }
}
