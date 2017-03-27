<?php

namespace PCForge;

use Illuminate\Database\Eloquent\Model;

class MotherboardComponent extends Model
{
    use ComponentChild, Validatable, VideoOutputer;

    protected $fillable = [
        'id',
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
        'length',
        'atx12v_pins',
        'socket_id',
        'sata_slots',
    ];

    private $createRules = [
        'id'                  => 'nullable|integer|unique:motherboard_components|min:0',
        'component_id'        => 'required|exists:components,id|unique:motherboard_components',
        'audio_headers'       => 'required|integer|min:0',
        'fan_headers'         => 'required|integer|min:0',
        'usb2_headers'        => 'required|integer|min:0',
        'usb3_headers'        => 'required|integer|min:0',
        'form_factor_id'      => 'required|exists:form_factors,id',
        'has_displayport_out' => 'required|boolean',
        'has_dvi_out'         => 'required|boolean',
        'has_hdmi_out'        => 'required|boolean',
        'has_vga_out'         => 'required|boolean',
        'pcie3_slots'         => 'required|integer|min:0',
        'supports_sli'        => 'required|boolean',
        'dimm_gen'            => 'required|integer|min:0',
        'dimm_pins'           => 'required|integer|min:0',
        'dimm_slots'          => 'required|integer|min:0',
        'dimm_max_capacity'   => 'required|integer|min:0',
        'length'              => 'required|integer|min:0',
        'atx12v_pins'         => 'required|integer|min:0',
        'socket_id'           => 'required|exists:sockets,id',
        'sata_slots'          => 'required|integer|min:0',
    ];

    private $updateRules = [
        'id'                  => 'nullable|integer|unique:motherboard_components|min:0',
        'component_id'        => 'nullable|exists:components,id|unique:motherboard_components',
        'audio_headers'       => 'nullable|integer|min:0',
        'fan_headers'         => 'nullable|integer|min:0',
        'usb2_headers'        => 'nullable|integer|min:0',
        'usb3_headers'        => 'nullable|integer|min:0',
        'form_factor_id'      => 'nullable|exists:form_factors,id',
        'has_displayport_out' => 'nullable|boolean',
        'has_dvi_out'         => 'nullable|boolean',
        'has_hdmi_out'        => 'nullable|boolean',
        'has_vga_out'         => 'nullable|boolean',
        'pcie3_slots'         => 'nullable|integer|min:0',
        'supports_sli'        => 'nullable|boolean',
        'dimm_gen'            => 'nullable|integer|min:0',
        'dimm_pins'           => 'nullable|integer|min:0',
        'dimm_slots'          => 'nullable|integer|min:0',
        'dimm_max_capacity'   => 'nullable|integer|min:0',
        'length'              => 'nullable|integer|min:0',
        'atx12v_pins'         => 'nullable|integer|min:0',
        'socket_id'           => 'nullable|exists:sockets,id',
        'sata_slots'          => 'nullable|integer|min:0',
    ];

    public function form_factor()
    {
        return $this->hasOne('PCForge\FormFactor', 'id', 'form_factor_id');
    }

    public function socket()
    {
        return $this->hasOne('PCForge\Socket');
    }
}
