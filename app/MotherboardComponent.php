<?php

namespace PCForge;

use Illuminate\Database\Eloquent\Model;

class MotherboardComponent extends Model
{
    use ComponentChild, Validatable;

    protected $fillable = [
        'id',
        'component_id',
        'audio_headers',
        'fan_headers',
        'form_factor',
        'usb2_headers',
        'usb3_headers',
        'has_displayport_out',
        'has_dvi_out',
        'has_hdmi_out',
        'has_vga_out',
        'pcie3_slots',
        'supports_sli',
        'dimm_frequency',
        'dimm_pins',
        'dimm_slots',
        'dimm_max_memory_size',
        'processor_socket',
        'atx12v_pins',
        'sata_slots',
    ];

    private $createRules = [
        'id'                   => 'nullable|integer|unique:motherboard_components|min:0',
        'component_id'         => 'required|exists:components,id',
        'audio_headers'        => 'required|integer|min:0',
        'fan_headers'          => 'required|integer|min:0',
        'form_factor'          => 'required|string',
        'usb2_headers'         => 'required|integer|min:0',
        'usb3_headers'         => 'required|integer|min:0',
        'has_displayport_out'  => 'required|boolean',
        'has_dvi_out'          => 'required|boolean',
        'has_hdmi_out'         => 'required|boolean',
        'has_vga_out'          => 'required|boolean',
        'pcie3_slots'          => 'required|integer|min:0',
        'supports_sli'         => 'required|boolean',
        'dimm_frequency'       => 'required|integer|min:0',
        'dimm_pins'            => 'required|integer|min:0',
        'dimm_slots'           => 'required|integer|min:0',
        'dimm_max_memory_size' => 'required|integer|min:0',
        'processor_socket'     => 'required|string',
        'atx12v_pins'          => 'required|integer|min:0',
        'sata_slots'           => 'required|integer|min:0',
    ];

    private $updateRules = [
        'id'                   => 'nullable|integer|unique:motherboard_components|min:0',
        'component_id'         => 'nullable|exists:components,id',
        'audio_headers'        => 'nullable|integer|min:0',
        'fan_headers'          => 'nullable|integer|min:0',
        'form_factor'          => 'nullable|string',
        'usb2_headers'         => 'nullable|integer|min:0',
        'usb3_headers'         => 'nullable|integer|min:0',
        'has_displayport_out'  => 'nullable|boolean',
        'has_dvi_out'          => 'nullable|boolean',
        'has_hdmi_out'         => 'nullable|boolean',
        'has_vga_out'          => 'nullable|boolean',
        'pcie3_slots'          => 'nullable|integer|min:0',
        'supports_sli'         => 'nullable|boolean',
        'dimm_frequency'       => 'nullable|integer|min:0',
        'dimm_pins'            => 'nullable|integer|min:0',
        'dimm_slots'           => 'nullable|integer|min:0',
        'dimm_max_memory_size' => 'nullable|integer|min:0',
        'processor_socket'     => 'nullable|string',
        'atx12v_pins'          => 'nullable|integer|min:0',
        'sata_slots'           => 'nullable|integer|min:0',
    ];
}
