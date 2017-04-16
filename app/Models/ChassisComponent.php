<?php

namespace PCForge\Models;

use Illuminate\Support\Collection;

class ChassisComponent extends ComponentChild
{
    protected $fillable = [
        'component_id',
        'max_cooling_fan_height',
        'max_graphics_length_blocked',
        'max_graphics_length_full',
        'audio_headers',
        'fan_headers',
        'usb2_headers',
        'usb3_headers',
        'uses_sata_power',
        '2p5_bays',
        '3p5_bays',
        'adaptable_bays',
    ];

    protected $presenter = 'PCForge\Presenters\ChassisComponentPresenter';

    public function form_factors()
    {
        return $this->belongsToMany(FormFactor::class);
    }

    public function radiators()
    {
        return $this->belongsToMany(ChassisComponentsRadiator::class);
    }

    public function getStaticallyCompatibleComponents(): Collection
    {
        // motherboard
        $components[] = MotherboardComponent
            ::where('audio_headers', '>=', $this->audio_headers)
            ->where('fan_headers', '>=', $this->fan_headers)
            ->where('usb2_headers', '>=', $this->usb2_headers)
            ->where('usb3_headers', '>=', $this->usb3_headers)
            ->whereIn('form_factor_id', $this->form_factors->pluck('id'))
            ->pluck('component_id');

        // power
        $components[] = PowerComponent::pluck('component_id');

        return collect($components)->flatten();
    }

    public function getStaticallyIncompatibleComponents(): Collection
    {
        // chassis
        $components[] = ChassisComponent::where('id', '!=', $this->id)->pluck('component_id');

        // cooling TODO: check radiators
        $components[] = CoolingComponent::where('height', '>', $this->max_cooling_fan_height)->pluck('component_id');

        // graphics TODO: check unblocked lengths
        $components[] = GraphicsComponent::where('length', '>', $this->max_graphics_length_blocked)->pluck('component_id');

        // motherboard
        $components[] = MotherboardComponent
            ::where('audio_headers', '<', $this->audio_headers)
            ->orWhere('fan_headers', '<', $this->fan_headers)
            ->orWhere('usb2_headers', '<', $this->usb2_headers)
            ->orWhere('usb3_headers', '<', $this->usb3_headers)
            ->orWhereNotIn('form_factor_id', $this->form_factors->pluck('id'))
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
