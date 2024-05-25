<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = "carts";
    protected $fillable = [
        "product_id",
        "user_id",
        "amount",
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    protected $appends = ['product'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
    public function getProductAttribute()
    {
        return Products::where('id', $this->attributes['product_id'])->first();
    }
}
