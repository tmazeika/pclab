<?php

namespace PCForge\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreComponentRequirement extends FormRequest
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
            'component_id'      => 'required|exists:components,id',
            'component_type_id' => 'required|exists:component_types,id',
            'minimum'           => 'required|integer|min:0|max:99',
            'maximum'           => 'required|integer|min:-1|max:99',
        ];
    }
}
