<?php

namespace PCForge\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMemoryComponent extends FormRequest
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
            'component_id'  => 'required|exists:components,id|unique:memory_components',
            'count'         => 'required|integer|min:0',
            'height'        => 'required|integer|min:0',
            'capacity_each' => 'required|integer|min:0',
            'ddr_gen'       => 'required|integer|min:0',
            'pins'          => 'required|integer|min:0',
        ];
    }
}
