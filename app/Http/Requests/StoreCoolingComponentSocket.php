<?php

namespace PCForge\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCoolingComponentSocket extends FormRequest
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
            'cooling_component_id' => 'required|exists:cooling_components,id',
            'socket_id'            => 'required|exists:sockets,id',
        ];
    }
}
