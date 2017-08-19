<?php

namespace PCLab\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreChassisComponent extends FormRequest
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
            'component_id'                => 'required|exists:components,id|unique:chassis_components',
            'max_cooling_fan_height'      => 'required|integer|min:0',
            'max_graphics_length_blocked' => 'required|integer|min:0',
            'max_graphics_length_full'    => 'required|integer|min:0',
            'audio_headers'               => 'required|integer|min:0',
            'fan_headers'                 => 'required|integer|min:0',
            'usb2_headers'                => 'required|integer|min:0',
            'usb3_headers'                => 'required|integer|min:0',
            'uses_sata_power'             => 'required|boolean',
            'max_power_length'            => 'required|integer|min:0',
            '2p5_bays'                    => 'required|integer|min:0',
            '3p5_bays'                    => 'required|integer|min:0',
            'adaptable_bays'              => 'required|integer|min:0',
            'cage_2p5_bays'               => 'required|integer|min:0',
            'cage_3p5_bays'               => 'required|integer|min:0',
            'cage_adaptable_bays'         => 'required|integer|min:0',
        ];
    }
}
