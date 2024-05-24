<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsModel extends Model
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
        "categories_id ",
    ];

}
