<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $table = "discounts";
    protected $fillable = [
        "discount_value",
        "product_id",
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
