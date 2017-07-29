<?php

namespace PCForge\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreComponent extends FormRequest
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
            'component_type_id' => 'required|exists:component_types,id',
            'asin'              => 'required|string|unique:components',
            'is_available'      => 'required|boolean',
            'name'              => 'required|string',
            'price'             => 'required|integer|min:0',
            'watts_usage'       => 'required|integer|min:0',
            'weight'            => 'required|integer|min:0',
        ];
    }
}
