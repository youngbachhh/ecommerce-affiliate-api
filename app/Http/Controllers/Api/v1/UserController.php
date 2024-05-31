<?php

namespace App\Http\Controllers\Api\v1;


use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Responses\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\UserNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        try {
            $users = $this->userService->getAllUsers();
            return ApiResponse::success($users);
        } catch (\Exception $e) {
            Log::error('Failed to fetch users: ' . $e->getMessage());
            return ApiResponse::error('Failed to fetch users', 500);
        }
    }

    public function sendOtp(StoreUserRequest $request)
    {
        try {
            $is_user_confirm = $this->userService->sendCodeOtp($request->validated());
//            $request = new Request($is_user_confirm);
//            $request->merge(['otp' => $is_user_confirm['otp']]);
//            $this->store($request);
            return ApiResponse::success($is_user_confirm, 'User created successfully', 201);
        } catch (\Exception $e) {
            Log::error('Failed to create user: ' . $e->getMessage());
            return ApiResponse::error('Failed to create user ', 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $user = $this->userService->createUser($request->all());
            return ApiResponse::success($user, 'User created successfully', 201);
        } catch (\Exception $e) {
            Log::error('Failed to create user: ' . $e->getMessage());
            return ApiResponse::error('Failed to create user ', 500);
        }
    }
    public function show($id)
    {
        try {
            $user = $this->userService->getUserById($id);
            return ApiResponse::success($user);
        } catch (ModelNotFoundException $e) {
            $exception = new UserNotFoundException();
            return $exception->render(request());
        } catch (\Exception $e) {
            Log::error('Failed to fetch user: ' . $e->getMessage());
            return ApiResponse::error('Failed to fetch user', 500);
        }
    }

    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $user = $this->userService->updateUser($id, $request->validated());
            return ApiResponse::success($user, 'User updated successfully');
        } catch (ModelNotFoundException $e) {
            $exception = new UserNotFoundException();
            return $exception->render(request());
        } catch (\Exception $e) {
            Log::error('Failed to update user: ' . $e->getMessage());
            return ApiResponse::error('Failed to update user', 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->userService->deleteUser($id);
            return ApiResponse::success(null, 'User deleted successfully');
        } catch (ModelNotFoundException $e) {
            $exception = new UserNotFoundException();
            return $exception->render(request());
        } catch (\Exception $e) {
            Log::error('Failed to delete user: ' . $e->getMessage());
            return ApiResponse::error('Failed to delete user', 500);
        }
    }
}
