<?php

namespace PCForge\Models;

use PCForge\Presenters\ProcessorComponentPresenter;

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

    public function socket()
    {
        return $this->belongsTo(Socket::class);
    }
}
