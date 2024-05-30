<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
// use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        // try {
        //     // Lấy thông tin người dùng hiện tại từ JWT token
        //     $user = JWTAuth::parseToken()->authenticate();

        //     // Lấy user_id từ route và đảm bảo nó là số
        //     $routeUserId = (int) $this->route('user');

        //     // Kiểm tra xem user id trong token có khớp với user id trong route hay không
        //     return $user->id === $routeUserId;
        // } catch (\Exception $e) {
        //     // Nếu có lỗi khi xác thực JWT, trả về false
        return true;
        // }
    }

    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $this->route('user'),
            'password' => 'sometimes|required|string|min:6',
            'role_id' => 'sometimes|required|numeric',
            'address' => 'nullable|string|max:255',
            'referral_code' => 'nullable|string|max:255|unique:users',
            'referrer_id' => 'nullable|string|exists:users,id',
            'phone' => 'nullable|string|max:15',
            'status' => 'sometimes|required|string',
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
