<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ship extends Model
{
    use HasFactory;
    protected $table = "ship";
    protected $fillable = [
        "status",
        "begin_time",
        "end_time",
        "order_id",
    ];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
