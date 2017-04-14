<?php

namespace PCForge\Models;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CoolingComponent extends ComponentChild
{
    private const CREATE_RULES = [
        'id'                => 'nullable|integer|unique:cooling_components|min:0',
        'component_id'      => 'required|exists:components,id|unique:cooling_components',
        'is_air'            => 'required|boolean',
        'fan_width'         => 'required|integer|min:0',
        'height'            => 'required|integer|min:0',
        'max_memory_height' => 'required|integer|min:0',
        'radiator_length'   => 'required|integer|min:0',
    ];

    private const UPDATE_RULES = [
        'id'                => 'nullable|integer|unique:cooling_components|min:0',
        'component_id'      => 'nullable|exists:components,id|unique:cooling_components',
        'is_air'            => 'nullable|boolean',
        'fan_width'         => 'nullable|integer|min:0',
        'height'            => 'nullable|integer|min:0',
        'max_memory_height' => 'nullable|integer|min:0',
        'radiator_length'   => 'nullable|integer|min:0',
    ];

    protected $fillable = [
        'id',
        'component_id',
        'is_air',
        'fan_width',
        'height',
        'max_memory_height',
        'radiator_length',
    ];

    public function sockets()
    {
        return $this->belongsToMany('PCForge\Models\Socket');
    }

    public function getStaticallyCompatibleComponents(): Collection
    {
        $id = $this->id;

        // motherboard
        $components[] = MotherboardComponent
            ::whereExists(function ($query) use ($id) {
                $query
                    ->select(DB::raw(1))
                    ->from('cooling_component_socket')
                    ->where('cooling_component_id', $id)
                    ->whereRaw('cooling_component_socket.socket_id = motherboard_components.socket_id');
            })
            ->pluck('component_id');

        return collect($components)->flatten();
    }

    public function getStaticallyIncompatibleComponents(): Collection
    {
        $id = $this->id;

        // chassis TODO: check radiators
        $components[] = ChassisComponent
            ::where('max_cooling_fan_height', '<', $this->height)
            ->pluck('component_id');

        // cooling
        $components[] = CoolingComponent
            ::where('id', '!=', $this->id)
            ->pluck('component_id');

        // memory
        $components[] = MemoryComponent
            ::where('height', '>', $this->max_memory_height)
            ->pluck('component_id');

        // motherboard
        $components[] = MotherboardComponent
            ::whereNotExists(function ($query) use ($id) {
                $query
                    ->select(DB::raw(1))
                    ->from('cooling_component_socket')
                    ->where('cooling_component_id', $id)
                    ->whereRaw('cooling_component_socket.socket_id = motherboard_components.socket_id');
            })
            ->pluck('component_id');

        // processor
        $components[] = ProcessorComponent
            ::whereNotExists(function ($query) use ($id) {
                $query
                    ->select(DB::raw(1))
                    ->from('cooling_component_socket')
                    ->where('cooling_component_id', $id)
                    ->whereRaw("cooling_component_socket.socket_id = processor_components.socket_id");
            })
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
