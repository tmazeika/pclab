<?php

namespace PCForge\Models;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CoolingComponent extends ComponentChild
{
    protected $fillable = [
        'component_id',
        'is_air',
        'fan_width',
        'height',
        'max_memory_height',
        'radiator_length',
    ];

    protected $presenter = 'PCForge\Presenters\CoolingComponentPresenter';

    public function sockets()
    {
        return $this->belongsToMany(Socket::class);
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
