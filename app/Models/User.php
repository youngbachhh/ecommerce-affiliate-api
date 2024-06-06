<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'users';
    protected $fillable = [
        "email",
        "name",
        "address",
        "password",
        "referral_code",
        'referrer_id',
        'phone',
        'role_id',
        'status',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['role'];

    public function getRoleAttribute(){
      return  Role::where('id',$this->attributes['role_id'])->first();
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function userInfo()
    {
        return $this->hasOne(UserInfo::class);
    }
    public function commission()
    {
        return $this->belongsTo(Commission::class);
    }
    public function transactions()
    {
        return $this->hasOne(Transaction::class);
    }
    public function role()
    {
        return $this->hasOne(Role::class);
    }
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }
    public function ship()
    {
        return $this->hasMany(Ship::class);
    }
    public function wallet()
    {
        return $this->belongsToMany(Wallet::class)->withTimestamps();
    }
}
