<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetailModel extends Model
{
    use HasFactory;
    protected $table = "order_detail";
    protected $fillable = [
        "quantity",
        "price",
        "total_money",
        "order_id",
        "product_id",
    ];
}
