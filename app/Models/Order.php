<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = "orders";
    protected $fillable = [
        "name",
        "email",
        "address",
        "phone",
        "total_money",
        "status",
        "note",
        "receive_address",
        "user_id"
    ];
    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function ship()
    {
        return $this->hasOne(Ship::class);
    }
}
