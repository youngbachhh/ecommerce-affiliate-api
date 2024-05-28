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
        "price",
        "product_unit",
        "quantity",
        "description",
        "is_featured",
        "is_new_arrival",
        "reviews",
        "commission_rate",
        "categories_id",
        "discount_id",
    ];
    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }
    public function carts()
    {
        return $this->belongsToMany(Cart::class);
    }
    public function categories()
    {
        return $this->belongsTo(Product::class);
    }
    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }
}
