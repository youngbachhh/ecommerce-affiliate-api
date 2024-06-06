<?php

namespace App\Services;


use App\Events\EventRegister;
use App\Http\Responses\ApiResponse;
use Exception;
use App\Models\User;
use App\Models\Wallet;
use Faker\Generator as Faker;
use Illuminate\http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
//use Illuminate\Support\Facades\Log;
//use Exception;
use Carbon\Carbon;

class UserService
{
    protected $user;
    protected $faker;
    protected $wallet;

    public function __construct(User $user, Faker $faker, Wallet $wallet)
    {
        $this->user = $user;
        $this->faker = $faker;
        $this->wallet = $wallet;
    }

    /**
     * Hàm lấy ra thông tin của tất cả người dùng
     * @param $id
     * @return $user
     * CreatedBy: youngbachhh (24/05/2024)
     * UpdatedBy: youngbachhh (27/05/2024)
     */
    public function getAllUsers(): \Illuminate\Database\Eloquent\Collection
    {
        try {
            Log::info('Fetching all users');
            return $this->user->all();
        } catch (Exception $e) {
            Log::error('Failed to fetch users: ' . $e->getMessage());
            throw new Exception('Failed to fetch users');
        }
    }

    /**
     * Hàm lấy ra thông tin của người dùng theo id
     *
     * @param int $id
     * @return User
     * @throws ModelNotFoundException
     * CreatedBy: youngbachhh (24/05/2024)
     * UpdatedBy: youngbachhh (27/05/2024)
     */
    public function getUserById(int $id): User
    {
        Log::info("Fetching user with ID: $id");
        $user = $this->user->find($id);

        if (!$user) {
            Log::warning("User with ID: $id not found");
            throw new ModelNotFoundException("User not found");
        }

        return $user;
    }

    /**
     * Hàm tạo mới người dùng
     *
     * @param array $data
     * @return User
     * CreatedBy: youngbachhh (24/05/2024)
     * UpdatedBy: youngbachhh (27/05/2024)
     */

    public function sendCodeOtp($data)
    {

        try {
            Log::info("Creating a new user with phone: {$data['phone'] }");
            $referral_id = $data['referral_code'];
            $findUser = $this->user->where('referrer_id',$referral_id)->get();
            $is_result = $findUser->toArray();
            $user = [
                'name' => @$data['name'],
                'email' => @$data['email'],
                'password' => Hash::make($data['password']),
                'address' => @$data['address'],
                'referral_code' => $this->randomReferalCode(),
                // 'referral_code' => $this->randomReferralCode(),
                // 'referrer_id' => $data['referrer_id'],
                'phone' => @$data['phone'],
                'referrer_id' => $is_result[0]['referrer_id'],
                'role_id' => 3,
                'status' => 'active',
                'otp'=> @$data['otp'],
            ];
            event(new EventRegister($user,@$data['otp']));
            return $user;
        } catch (Exception $e) {
            Log::error("Failed to create user: {$e->getMessage()}");
            throw $e;
        }
    }
    public function createUser(array $data)
    {
        DB::beginTransaction();
        try {
            Log::info("Creating a new user with phone: {$data['phone'] }");
            $referral_id = $data['referral_code'];
            $findUser = $this->user->where('referrer_id',$referral_id)->get();
            $is_result = $findUser->toArray();
            $user = $this->user->create([
                'name' => @$data['name'],
                'email' => @$data['email'],
                'password' => Hash::make($data['password']),
                'address' => @$data['address'],
                'referral_code' => $is_result[0]['referrer_id'],
                'phone' => @$data['phone'],
                'referrer_id' => $this->randomReferalCode(),
                'role_id' => 3,
                'status' => 'active',
            ]);

            $wallets = $this->wallet->all()->pluck('id')->toArray();
            foreach ($wallets as $wallet) {
                $user->wallet()->attach($wallet);
            }
            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Failed to create user: {$e->getMessage()}");
            throw $e;
        }
    }
    /**
     * Cập nhật thông tin người dùng
     *
     * @param int $id
     * @param array $data
     * @return User
     * @throws ModelNotFoundException
     * CreatedBy: youngbachhh (24/05/2024)
     * UpdatedBy: youngbachhh (27/05/2024)
     */
    public function updateUser(int $id, array $data): User
    {
        DB::beginTransaction();

        try {
            $user = $this->getUserById($id);

            Log::info("Updating user with ID: $id");
            $user->update($data);

            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Failed to update user: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Xóa người dùng
     *
     * @param int $id
     * @throws ModelNotFoundException
     * CreatedBy: youngbachhh (24/05/2024)
     * UpdatedBy: youngbachhh (27/05/2024)
     */
    public function deleteUser(int $id): void
    {
        DB::beginTransaction();

        try {
            $user = $this->getUserById($id);

            Log::info("Deleting user with ID: $id");
            $user->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Failed to delete user: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Random mã giới thiệu
     *
     * @param void
     * @return $rand
     * CreatedBy: svellsongur (28/05/2024)
     * UpdatedBy: svellsongur (30/05/2024)
     */
    protected function randomReferalCode()
    {
        $rand =  "RI" . $this->faker->numberBetween(10000000, 99999999);

        $exist_user = User::where('referral_code', $rand)->exists();
        while ($exist_user) {
            $this->randomReferalCode();
        }

        return $rand;
    }
}
