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
        "product_id",
        "user_id"
    ];
    public function orderDetail()
    {
        return $this->hasOne(OrderDetail::class);
    }
    public function payment()
    {
        return $this->hasOne(Order::class);
    }
    public function ship()
    {
        return $this->hasOne(Ship::class);
    }
}
