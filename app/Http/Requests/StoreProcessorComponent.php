<?php

namespace PCForge\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProcessorComponent extends FormRequest
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
            'component_id'     => 'required|exists:components,id|unique:processor_components',
            'cores'            => 'required|integer|min:0',
            'has_apu'          => 'required|boolean',
            'has_stock_cooler' => 'required|boolean',
            'socket_id'        => 'required|exists:sockets,id',
            'speed'            => 'required|integer|min:0',
        ];
    }
}
