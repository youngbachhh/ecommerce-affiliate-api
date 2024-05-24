<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class User extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $fillable = [
        "email",
        "name",
        "address",
        "password",
        "referral_code",
        'referrer_id',
        'total_revenue',
        'wallet',
        'bonus_wallet',
        'phone',
        'role_id',
        'is_active',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function userInfo()
    {
        return $this->hasOne(UserInfoModel::class);
    }
    public function commission()
    {
        return $this->hasOne(CommissionModel::class);
    }
    public function transactions()
    {
        return $this->hasOne(TransactionsModel::class);
    }
    public function role()
    {
        return $this->hasOne(RoleModel::class);
    }
    public function cart()
    {
        return $this->hasOne(CartModel::class);
    }
}
