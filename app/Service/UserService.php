<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserService
{
    /**
     * Hàm lấy ra thông tin của tất cả user
     * @param $id
     * @return $user
     * CreatedBy: youngbachhh (24/05/2024)
     */
    public function getAllUsers()
    {
        return User::all();
    }

    /**
     * Hàm lấy ra thông tin của user theo id
     * @param $id
     * @return $user
     * CreatedBy: youngbachhh (24/05/2024)
     */
    public function getUserById($id)
    {
        $user = User::find($id);
        if (!$user) {
            throw new ModelNotFoundException("User not found");
        }
        return $user;
    }

    /**
     * Hàm tạo mới user
     * @param $data
     * @return $user
     * CreatedBy: youngbachhh (24/05/2024)
     */
    public function createUser(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Hàm cập nhật thông tin user
     * @param $id
     * @param $data
     * @return $user
     * CreatedBy: youngbachhh (24/05/2024)
     */
    public function updateUser($id, array $data)
    {
        $user = $this->getUserById($id);

        $user->update($data);

        return $user;
    }

    /**
     * Hàm xóa user
     * @param $id
     * CreatedBy: youngbachhh (24/05/2024)
     */
    public function deleteUser($id)
    {
        $user = $this->getUserById($id);

        $user->delete();
    }
}
