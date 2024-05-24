<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionModel extends Model
{
    use HasFactory;
    protected $table = "commission";
    protected $fillable = [
        "commission_rate",
        "level",
        "user_id"
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
