<?php

namespace PCForge\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePowerComponent extends FormRequest
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
            'component_id' => 'required|exists:components,id|unique:power_components',
            'atx12v_pins'  => 'required|integer|min:0',
            'sata_powers'  => 'required|integer|min:0',
            'is_modular'   => 'required|boolean',
            'watts_out'    => 'required|integer|min:0',
        ];
    }
}
