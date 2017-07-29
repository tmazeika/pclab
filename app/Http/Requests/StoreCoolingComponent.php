<?php

namespace PCForge\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCoolingComponent extends FormRequest
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
            'component_id'      => 'required|exists:components,id|unique:cooling_components',
            'is_air'            => 'required|boolean',
            'fan_width'         => 'required|integer|min:0',
            'height'            => 'required|integer|min:0',
            'max_memory_height' => 'required|integer|min:0',
            'radiator_length'   => 'required|integer|min:0',
        ];
    }
}
