<?php

namespace PCForge\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMotherboardComponent extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // TODO
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
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
            'atx12v_pins'         => 'required|integer|min:0',
            'socket_id'           => 'required|exists:sockets,id',
            'sata_slots'          => 'required|integer|min:0',
        ];
    }
}
