<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'pizzas' => 'array|min:1',
            'pizzas.*.pizza_id' => 'required|exists:pizzas,id',
            'pizzas.*.count' => 'required|min:1',
            'delivery_needed' => 'required|in:0,1',
            'address' => 'required_if:delivery_needed,1|string',
            'name' => 'required_if:delivery_needed,1|string',
            'phone' => 'required_if:delivery_needed,1|string',
            'remember_delivery' => 'sometimes|in:0,1'
        ];
    }
}
