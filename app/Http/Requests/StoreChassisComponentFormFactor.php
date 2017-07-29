<?php

namespace PCForge\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreChassisComponentFormFactor extends FormRequest
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
            'chassis_component_id' => 'required|exists:chassis_components,id',
            'form_factor_id'       => 'required|exists:form_factors,id',
        ];
    }
}
