<?php

namespace PCForge\Models;

use Illuminate\Support\Collection;

class ProcessorComponent extends ComponentChild
{
    protected $fillable = [
        'component_id',
        'cores',
        'has_apu',
        'has_stock_cooler',
        'socket_id',
        'speed',
    ];

    protected $presenter = 'PCForge\Presenters\ProcessorComponentPresenter';

    public function socket()
    {
        return $this->belongsTo(Socket::class);
    }

    public function getStaticallyCompatibleComponents(): Collection
    {
        // motherboard
        return MotherboardComponent
            ::where('socket_id', $this->socket_id)
            ->pluck('component_id')
            ->flatten();
    }

    public function getStaticallyIncompatibleComponents(): Collection
    {
        // motherboard
        $components[] = MotherboardComponent
            ::where('socket_id', '!=', $this->socket_id)
            ->pluck('component_id');

        // processor
        $components[] = ProcessorComponent
            ::where('id', '!=', $this->id)
            ->pluck('component_id');

        return collect($components)->flatten();
    }

    public function getDynamicallyCompatibleComponents(array $selected): Collection
    {
        return collect();
    }

    public function getDynamicallyIncompatibleComponents(array $selected): Collection
    {
        return collect();
    }
}
