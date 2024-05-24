<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
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

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
