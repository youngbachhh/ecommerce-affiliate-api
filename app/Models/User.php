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
        return $this->hasOne(UserInfo::class);
    }
    public function commission()
    {
        return $this->hasOne(Commission::class);
    }
    public function transactions()
    {
        return $this->hasOne(Transactions::class);
    }
    public function role()
    {
        return $this->hasOne(Role::class);
    }
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }
}
