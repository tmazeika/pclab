<?php

namespace PCForge\Compatibility;

use Illuminate\Support\Collection;
use PCForge\Contracts\ComponentRepositoryContract;
use PCForge\Models\ChassisComponent;
use PCForge\Models\CoolingComponent;
use PCForge\Models\GraphicsComponent;
use PCForge\Models\MotherboardComponent;
use PCForge\Models\PowerComponent;

class ChassisComponentCompatibilityProvider implements CompatibilityProvider
{
    public function getStaticallyCompatible($component): Collection
    {
        // motherboard
        $components[] = MotherboardComponent
            ::where('audio_headers', '>=', $component->audio_headers)
            ->where('fan_headers', '>=', $component->fan_headers)
            ->where('usb2_headers', '>=', $component->usb2_headers)
            ->where('usb3_headers', '>=', $component->usb3_headers)
            ->whereIn('form_factor_id', $component->form_factors->pluck('id'))
            ->pluck('component_id');

        // power
        $components[] = PowerComponent::pluck('component_id');

        return collect($components)->flatten();
    }

    public function getStaticallyIncompatible($component): Collection
    {
        // chassis
        $components[] = ChassisComponent::where('id', '!=', $component->id)->pluck('component_id');

        // cooling TODO: check radiators
        $components[] = CoolingComponent::where('height', '>', $component->max_cooling_fan_height)->pluck('component_id');

        // graphics TODO: check unblocked lengths
        $components[] = GraphicsComponent::where('length', '>', $component->max_graphics_length_blocked)->pluck('component_id');

        // motherboard
        $components[] = MotherboardComponent
            ::where('audio_headers', '<', $component->audio_headers)
            ->orWhere('fan_headers', '<', $component->fan_headers)
            ->orWhere('usb2_headers', '<', $component->usb2_headers)
            ->orWhere('usb3_headers', '<', $component->usb3_headers)
            ->orWhereNotIn('form_factor_id', $component->form_factors->pluck('id'))
            ->pluck('component_id');

        return collect($components)->flatten();
    }

    public function getDynamicallyCompatible($component): Collection
    {
        return collect();
    }

    public function getDynamicallyIncompatible($component): Collection
    {
        return collect();
    }

    public function getComponentType(): string
    {
        return 'chassis';
    }
}
