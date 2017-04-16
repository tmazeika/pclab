<?php

namespace PCForge\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStorageComponent extends FormRequest
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
            'component_id'     => 'required|exists:components,id|unique:storage_components',
            'capacity'         => 'required|integer|min:0',
            'is_ssd'           => 'required|boolean',
            'storage_width_id' => 'required|exists:storage_widths,id',
        ];
    }
}
