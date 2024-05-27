<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class UpdateProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'product_unit' => 'required',
            'categories_id' => 'required',
        ];
    }
}
