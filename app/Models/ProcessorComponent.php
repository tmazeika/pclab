<?php

namespace PCForge\Models;

use Illuminate\Support\Collection;

class ProcessorComponent extends ComponentChild
{
    private const CREATE_RULES = [
        'id'               => 'nullable|integer|unique:processor_components|min:0',
        'component_id'     => 'required|exists:components,id|unique:processor_components',
        'cores'            => 'required|integer|min:0',
        'has_apu'          => 'required|boolean',
        'has_stock_cooler' => 'required|boolean',
        'socket_id'        => 'required|exists:sockets,id',
        'speed'            => 'required|integer|min:0',
    ];

    private const UPDATE_RULES = [
        'id'               => 'nullable|integer|unique:processor_components|min:0',
        'component_id'     => 'nullable|exists:components,id|unique:processor_components',
        'cores'            => 'nullable|integer|min:0',
        'has_apu'          => 'nullable|boolean',
        'has_stock_cooler' => 'nullable|boolean',
        'socket_id'        => 'nullable|exists:sockets,id',
        'speed'            => 'nullable|integer|min:0',
    ];

    protected $fillable = [
        'id',
        'component_id',
        'cores',
        'has_apu',
        'has_stock_cooler',
        'socket_id',
        'speed',
    ];

    public function socket()
    {
        return $this->belongsTo('PCForge\Models\Socket');
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
