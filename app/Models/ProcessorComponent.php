<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;

class ProcessorComponent extends Model implements CompatibilityNode
{
    use ExtendedModel, ComponentChild, Validatable;

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

    public function getAllDirectlyCompatibleComponents(): array
    {
        // motherboard
        $components[] = MotherboardComponent
            ::where('socket_id', $this->socket_id)
            ->pluck('component_id')
            ->all();

        return array_merge(...$components);
    }

    public function getAllDirectlyIncompatibleComponents(): array
    {
        // motherboard
        $components[] = MotherboardComponent
            ::where('socket_id', '!=', $this->socket_id)
            ->pluck('component_id')
            ->all();

        // processor
        $components[] = ProcessorComponent
            ::where('id', '!=', $this->id)
            ->pluck('component_id')
            ->all();

        return array_merge(...$components);
    }

    public function getAllDynamicallyCompatibleComponents(array $selectedComponentIds): array
    {
        return [];
    }

    public function getAllDynamicallyIncompatibleComponents(array $selectedComponentIds): array
    {
        return [];
    }
}
