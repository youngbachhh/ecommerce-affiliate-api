<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric',
            'quantity' => 'sometimes|required|numeric',
            'product_unit' => 'nullable|string',
            'category_id' => 'sometimes|required|exists:categories,id',
            'product_unit' => 'nullable|string',
            'description' => 'sometimes|required|string',
            'is_featured' => 'nullable|boolean',
            'is_new_arrival' => 'nullable|boolean',
            'commission_rate' => 'sometimes|numeric|between:0,100',
            'discount_id' => 'nullable|numeric|exists:discounts,id'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.*
     * @return array
     */
    protected function failedValidation(Validator $validator)
    {
        return false;
    }
}
