<?php

namespace PCForge\Compatibility\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use PCForge\Contracts\ComponentRepositoryContract;
use PCForge\Models\ChassisComponent;
use PCForge\Models\CoolingComponent;
use PCForge\Models\MemoryComponent;
use PCForge\Models\MotherboardComponent;
use PCForge\Models\ProcessorComponent;

class MotherboardComponentCompatibilityProvider implements CompatibilityProvider
{
    /** @var ComponentRepositoryContract $components */
    private $components;

    public function __construct(ComponentRepositoryContract $componentRepo)
    {
        $this->components = $componentRepo;
    }

    public function getStaticallyCompatible($component): Collection
    {
        $formFactorId = $component->form_factor->id;
        $socketId = $component->socket->id;

        return collect([
            $this->components->withParent(ChassisComponent::class)->where('audio_headers', '<=', $component->audio_headers)
                ->where('fan_headers', '<=', $component->fan_headers)
                ->where('usb2_headers', '<=', $component->usb2_headers)
                ->where('usb3_headers', '<=', $component->usb3_headers)
                ->whereExists(function ($query) use ($formFactorId) {
                    $query
                        ->select(DB::raw(1))
                        ->from('chassis_component_form_factor')
                        ->whereRaw('chassis_component_form_factor.chassis_component_id = chassis_components.id')
                        ->where('form_factor_id', $formFactorId);
                })
                ->pluck('components.id'),
            $this->components->withParent(CoolingComponent::class)->whereExists(function ($query) use ($socketId) {
                    $query
                        ->select(DB::raw(1))
                        ->from('cooling_component_socket')
                        ->whereRaw('cooling_component_socket.cooling_component_id = cooling_components.id')
                        ->where('socket_id', $socketId);
                })
                ->pluck('components.id'),
            $this->components->withParent(MemoryComponent::class)->where('ddr_gen', $component->dimm_gen)
                ->where('pins', $component->dimm_pins)
                ->pluck('components.id'),
            $this->components->withParent(ProcessorComponent::class)->where('socket_id', $socketId)
                ->pluck('components.id'),
        ])->flatten();
    }

    public function getStaticallyIncompatible($component): Collection
    {
        $formFactorId = $component->form_factor_id;
        $socketId = $component->socket_id;

        return collect([
            $this->components->withParent(ChassisComponent::class)
                ->where('audio_headers', '>', $component->audio_headers)
                ->orWhere('fan_headers', '>', $component->fan_headers)
                ->orWhere('usb2_headers', '>', $component->usb2_headers)
                ->orWhere('usb3_headers', '>', $component->usb3_headers)
                ->orWhereNotExists(function ($query) use ($formFactorId) {
                    $query
                        ->select(DB::raw(1))
                        ->from('chassis_component_form_factor')
                        ->whereRaw('chassis_component_form_factor.chassis_component_id = chassis_components.id')
                        ->where('form_factor_id', $formFactorId);
                })
                ->pluck('components.id'),
            $this->components->withParent(CoolingComponent::class)
                ->whereNotExists(function ($query) use ($socketId) {
                    $query
                        ->select(DB::raw(1))
                        ->from('cooling_component_socket')
                        ->whereRaw('cooling_component_socket.cooling_component_id = cooling_components.id')
                        ->where('socket_id', $socketId);
                })
                ->pluck('components.id'),
            $this->components->withParent(MemoryComponent::class)
                ->where('ddr_gen', '!=', $component->dimm_gen)
                ->orWhere('pins', '!=', $component->dimm_pins)
                ->pluck('components.id'),
            $this->components->withParent(MotherboardComponent::class)
                ->where('motherboard_components.id', '!=', $component->id)
                ->pluck('components.id'),
            $this->components->withParent(ProcessorComponent::class)
                ->where('socket_id', '!=', $socketId)
                ->pluck('components.id'),
        ])->flatten();
    }

    public function getDynamicallyCompatible($component, array $selection): Collection
    {
        return collect();
    }

    public function getDynamicallyIncompatible($component, array $selection): Collection
    {
        return collect();
    }
}
