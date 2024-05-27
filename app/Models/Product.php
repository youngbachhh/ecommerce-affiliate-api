<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = "products";
    protected $fillable = [
        "name",
        "thumbnail",
        "price",
        "product_unit",
        "quantity",
        "description",
        "is_featured",
        "is_new_arrival",
        "ratings",
        "reviews",
        "categories_id",
    ];
    public function discount()
    {
        return $this->hasOne(Discount::class);
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    public function categories()
    {
        return $this->belongsTo(Product::class);
    }
}