<?php

namespace PCForge\Compatibility\Providers;

use Illuminate\Support\Collection;
use PCForge\Contracts\ComponentRepositoryContract;
use PCForge\Models\ChassisComponent;
use PCForge\Models\CoolingComponent;
use PCForge\Models\GraphicsComponent;
use PCForge\Models\MotherboardComponent;
use PCForge\Models\PowerComponent;

class ChassisComponentCompatibilityProvider implements CompatibilityProvider
{
    /** @var ComponentRepositoryContract $components */
    private $components;

    public function __construct(ComponentRepositoryContract $componentRepo)
    {
        $this->components = $componentRepo;
    }

    public function getStaticallyCompatible($component): Collection
    {
        return collect([
            $this->components->withParent(MotherboardComponent::class)
                ->where('audio_headers', '>=', $component->audio_headers)
                ->where('fan_headers', '>=', $component->fan_headers)
                ->where('usb2_headers', '>=', $component->usb2_headers)
                ->where('usb3_headers', '>=', $component->usb3_headers)
                ->whereIn('form_factor_id', $component->form_factors->pluck('id'))
                ->pluck('components.id'),
            $this->components->withParent(PowerComponent::class)
                ->pluck('components.id'),
        ]);
    }

    public function getStaticallyIncompatible($component): Collection
    {
        return collect([
            $this->components->withParent(ChassisComponent::class)
                ->where('chassis_components.id', '!=', $component->id)
                ->pluck('components.id'),
            // TODO: check radiators
            $this->components->withParent(CoolingComponent::class)
                ->where('height', '>', $component->max_cooling_fan_height)
                ->pluck('components.id'),
            // TODO: check unblocked lengths
            $this->components->withParent(GraphicsComponent::class)
                ->where('length', '>', $component->max_graphics_length_blocked)
                ->pluck('components.id'),
            $this->components->withParent(MotherboardComponent::class)
                ->where('audio_headers', '<', $component->audio_headers)
                ->orWhere('fan_headers', '<', $component->fan_headers)
                ->orWhere('usb2_headers', '<', $component->usb2_headers)
                ->orWhere('usb3_headers', '<', $component->usb3_headers)
                ->orWhereNotIn('form_factor_id', $component->form_factors->pluck('id'))
                ->pluck('components.id'),
        ]);
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
