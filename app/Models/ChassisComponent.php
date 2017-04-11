<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;

class ChassisComponent extends Model implements CompatibilityNode
{
    use ExtendedModel, ComponentChild, Validatable;

    private const CREATE_RULES = [
        'id'                          => 'nullable|integer|unique:chassis_components|min:0',
        'component_id'                => 'required|exists:components,id|unique:chassis_components',
        'max_cooling_fan_height'      => 'required|integer|min:0',
        'max_graphics_length_blocked' => 'required|integer|min:0',
        'max_graphics_length_full'    => 'required|integer|min:0',
        'audio_headers'               => 'required|integer|min:0',
        'fan_headers'                 => 'required|integer|min:0',
        'usb2_headers'                => 'required|integer|min:0',
        'usb3_headers'                => 'required|integer|min:0',
        'uses_sata_power'             => 'required|boolean',
        '2p5_bays'                    => 'required|integer|min:0',
        '3p5_bays'                    => 'required|integer|min:0',
        'adaptable_bays'              => 'required|integer|min:0',
    ];

    private const UPDATE_RULES = [
        'id'                          => 'nullable|integer|unique:chassis_components|min:0',
        'component_id'                => 'nullable|exists:components,id|unique:chassis_components',
        'max_cooling_fan_height'      => 'nullable|integer|min:0',
        'max_graphics_length_blocked' => 'nullable|integer|min:0',
        'max_graphics_length_full'    => 'nullable|integer|min:0',
        'audio_headers'               => 'nullable|integer|min:0',
        'fan_headers'                 => 'nullable|integer|min:0',
        'usb2_headers'                => 'nullable|integer|min:0',
        'usb3_headers'                => 'nullable|integer|min:0',
        'uses_sata_power'             => 'nullable|boolean',
        '2p5_bays'                    => 'nullable|integer|min:0',
        '3p5_bays'                    => 'nullable|integer|min:0',
        'adaptable_bays'              => 'nullable|integer|min:0',
    ];

    protected $fillable = [
        'id',
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

    public function form_factors()
    {
        return $this->belongsToMany('PCForge\Models\FormFactor');
    }

    public function radiators()
    {
        return $this->belongsToMany('PCForge\Models\ChassisRadiator');
    }

    public function getStaticallyCompatibleComponents(): array
    {
        // motherboard
        $components[] = MotherboardComponent
            ::where('audio_headers', '>=', $this->audio_headers)
            ->where('fan_headers', '>=', $this->fan_headers)
            ->where('usb2_headers', '>=', $this->usb2_headers)
            ->where('usb3_headers', '>=', $this->usb3_headers)
            ->whereIn('form_factor_id', $this->form_factors->pluck('id')->all())
            ->pluck('component_id')
            ->all();

        // power
        $components[] = PowerComponent
            ::pluck('component_id')
            ->all();

        return array_merge(...$components);
    }

    public function getStaticallyIncompatibleComponents(): array
    {
        // chassis
        $components[] = ChassisComponent
            ::where('id', '!=', $this->id)
            ->pluck('component_id')
            ->all();

        // cooling TODO: check radiators
        $components[] = CoolingComponent
            ::where('height', '>', $this->max_cooling_fan_height)
            ->pluck('component_id')
            ->all();

        // graphics
        $components[] = GraphicsComponent
            ::where('length', '>', $this->max_graphics_length_blocked)
            ->pluck('component_id')
            ->all();

        // motherboard
        $components[] = MotherboardComponent
            ::where('audio_headers', '<', $this->audio_headers)
            ->orWhere('fan_headers', '<', $this->fan_headers)
            ->orWhere('usb2_headers', '<', $this->usb2_headers)
            ->orWhere('usb3_headers', '<', $this->usb3_headers)
            ->orWhereNotIn('form_factor_id', $this->form_factors->pluck('id')->all())
            ->pluck('component_id')
            ->all();

        return array_merge(...$components);
    }

    public function getDynamicallyCompatibleComponents(array $selected): array
    {
        return [];
    }

    public function getDynamicallyIncompatibleComponents(array $selected): array
    {
        return [];
    }
}
