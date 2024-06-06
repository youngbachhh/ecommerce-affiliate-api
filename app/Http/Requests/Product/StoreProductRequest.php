<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;


class StoreProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'categories_id' => 'required|numeric|exists:categories,id',
            'product_unit' => 'nullable|string',
            'description' => 'required|string',
            'is_featured' => 'nullable|boolean',
            'is_new_arrival' => 'nullable|boolean',
            'commission_rate' => 'sometimes|numeric|between:0,100',
            'discount_id' => 'sometimes|numeric|exists:discounts,id',
            'category_id'=> 'required',
            'images'=> 'required',
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
