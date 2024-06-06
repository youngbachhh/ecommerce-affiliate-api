<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = "products";
    protected $fillable = [
        "id",
        "name",
        "price",
        "product_unit",
        "quantity",
        "description",
        "is_featured",
        "is_new_arrival",
        "commission_rate",
        "category_id",
        "discount_id",
        "status"
    ];
    protected $appends = ['category','images'];
    public function getImagesAttribute(){
        return ProductImage::where('product_id',$this->attributes['id'])->get();
    }
    public function getCategoryAttribute(){
        return Category::where('id',$this->attributes['category_id'])->first();
    }
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
