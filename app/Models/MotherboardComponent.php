<?php

namespace PCForge\Models;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MotherboardComponent extends ComponentChild
{
    protected $fillable = [
        'component_id',
        'audio_headers',
        'fan_headers',
        'usb2_headers',
        'usb3_headers',
        'form_factor_id',
        'has_displayport_out',
        'has_dvi_out',
        'has_hdmi_out',
        'has_vga_out',
        'pcie3_slots',
        'supports_sli',
        'dimm_gen',
        'dimm_pins',
        'dimm_slots',
        'dimm_max_capacity',
        'atx12v_pins',
        'socket_id',
        'sata_slots',
    ];

    protected $presenter = 'PCForge\Presenters\MotherboardComponentPresenter';

    public function form_factor()
    {
        return $this->belongsTo(FormFactor::class);
    }

    public function socket()
    {
        return $this->belongsTo(Socket::class);
    }

    public function getStaticallyCompatibleComponents(): Collection
    {
        $formFactorId = $this->form_factor->id;
        $socketId = $this->socket->id;

        // chassis
        $components[] = ChassisComponent
            ::where('audio_headers', '<=', $this->audio_headers)
            ->where('fan_headers', '<=', $this->fan_headers)
            ->where('usb2_headers', '<=', $this->usb2_headers)
            ->where('usb3_headers', '<=', $this->usb3_headers)
            ->whereExists(function ($query) use ($formFactorId) {
                $query
                    ->select(DB::raw(1))
                    ->from('chassis_component_form_factor')
                    ->whereRaw('chassis_component_form_factor.chassis_component_id = chassis_components.id')
                    ->where('form_factor_id', $formFactorId);
            })
            ->pluck('component_id');

        // cooling
        $components[] = CoolingComponent
            ::whereExists(function ($query) use ($socketId) {
                $query
                    ->select(DB::raw(1))
                    ->from('cooling_component_socket')
                    ->whereRaw('cooling_component_socket.cooling_component_id = cooling_components.id')
                    ->where('socket_id', $socketId);
            })
            ->pluck('component_id');

        // memory
        $components[] = MemoryComponent
            ::where('ddr_gen', $this->dimm_gen)
            ->where('pins', $this->dimm_pins)
            ->pluck('component_id');

        // processor
        $components[] = ProcessorComponent::where('socket_id', $socketId)->pluck('component_id');

        return collect($components)->flatten();
    }

    public function getStaticallyIncompatibleComponents(): Collection
    {
        $formFactorId = $this->form_factor_id;
        $socketId = $this->socket_id;

        // chassis
        $components[] = ChassisComponent
            ::where('audio_headers', '>', $this->audio_headers)
            ->orWhere('fan_headers', '>', $this->fan_headers)
            ->orWhere('usb2_headers', '>', $this->usb2_headers)
            ->orWhere('usb3_headers', '>', $this->usb3_headers)
            ->orWhereNotExists(function ($query) use ($formFactorId) {
                $query
                    ->select(DB::raw(1))
                    ->from('chassis_component_form_factor')
                    ->whereRaw('chassis_component_form_factor.chassis_component_id = chassis_components.id')
                    ->where('form_factor_id', $formFactorId);
            })
            ->pluck('component_id');

        // cooling
        $components[] = CoolingComponent
            ::whereNotExists(function ($query) use ($socketId) {
                $query
                    ->select(DB::raw(1))
                    ->from('cooling_component_socket')
                    ->whereRaw('cooling_component_socket.cooling_component_id = cooling_components.id')
                    ->where('socket_id', $socketId);
            })
            ->pluck('component_id');

        // memory
        $components[] = MemoryComponent
            ::where('ddr_gen', '!=', $this->dimm_gen)
            ->orWhere('pins', '!=', $this->dimm_pins)
            ->pluck('component_id');

        // motherboard
        $components[] = MotherboardComponent::where('id', '!=', $this->id)->pluck('component_id');

        // processor
        $components[] = ProcessorComponent::where('socket_id', '!=', $socketId)->pluck('component_id');

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
