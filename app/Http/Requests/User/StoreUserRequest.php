<?php

namespace App\Http\Requests\User;

use App\Http\Responses\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role_id' => 'required|numeric',
            'address' => 'nullable|string|max:255',
            'referral_code' => 'nullable|string|max:255|unique:users',
            'referrer_id' => 'nullable|numeric|exists:users,id',
            'phone' => 'nullable|string|max:15',
            'status' => 'required|string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.*
     * @return array
     */
    protected function failedValidation(Validator $validator)
    {
        throw new \Illuminate\Validation\ValidationException($validator, ApiResponse::error($validator->errors(), 422));
    }
}
