<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property array pizzas
 * @property integer delivery_needed
 * @property integer remember_delivery
 * @property string address
 * @property string name
 * @property string phone
 */
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

    protected function prepareForValidation()
    {
        if ($this->phone != null) {
            $this->merge(['phone' => preg_replace('~[\D]~', '', $this->phone)]);
        }
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'address' => 'required|string',
            'name' => 'required|string',
            'phone' => 'required|string',
            'remember_delivery' => 'sometimes|accepted'
        ];
    }
}
