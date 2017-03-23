<?php

namespace PCForge;

use Illuminate\Database\Eloquent\Model;

class ChassisComponent extends Model
{
    use ComponentChild, Validatable;

    protected $fillable = [
        'id',
        'component_id',
        'max_fan_z',
        'chassis_components_radiator_id',
        'max_graphics_size_x_blocked',
        'max_graphics_size_x_full',
        'audio_headers',
        'fan_headers',
        'max_eatx_y',
        'usb2_headers',
        'usb3_headers',
        'uses_sata_power',
        '2p5_bays',
        '3p5_bays',
    ];

    private $createRules = [
        'id'                          => 'nullable|integer|unique:chassis_components|min:0',
        'component_id'                => 'required|exists:components,id',
        'max_fan_z'                   => 'required|integer|min:0',
        'max_graphics_size_x_blocked' => 'required|integer|min:0',
        'max_graphics_size_x_full'    => 'required|integer|min:0',
        'audio_headers'               => 'required|integer|min:0',
        'fan_headers'                 => 'required|integer|min:0',
        'max_eatx_y'                  => 'required|integer|min:0',
        'usb2_headers'                => 'required|integer|min:0',
        'usb3_headers'                => 'required|integer|min:0',
        'uses_sata_power'             => 'required|boolean',
        '2p5_bays'                    => 'required|integer|min:0',
        '3p5_bays'                    => 'required|integer|min:0',
    ];

    private $updateRules = [
        'id'                          => 'nullable|integer|unique:chassis_components|min:0',
        'component_id'                => 'nullable|exists:components,id',
        'max_fan_z'                   => 'nullable|integer|min:0',
        'max_graphics_size_x_blocked' => 'nullable|integer|min:0',
        'max_graphics_size_x_full'    => 'nullable|integer|min:0',
        'audio_headers'               => 'nullable|integer|min:0',
        'fan_headers'                 => 'nullable|integer|min:0',
        'max_eatx_y'                  => 'nullable|integer|min:0',
        'usb2_headers'                => 'nullable|integer|min:0',
        'usb3_headers'                => 'nullable|integer|min:0',
        'uses_sata_power'             => 'nullable|boolean',
        '2p5_bays'                    => 'nullable|integer|min:0',
        '3p5_bays'                    => 'nullable|integer|min:0',
    ];

    public function formFactors()
    {
        return $this->hasMany('PCForge\ChassisFormFactor');
    }

    public function radiators()
    {
        return $this->hasMany('PCForge\ChassisRadiator');
    }
}
