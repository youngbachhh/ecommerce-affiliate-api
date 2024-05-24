<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;
    protected  $table = 'role_permission';
    protected $fillable = [
        "gurd_name",
        "role_id",
    ];
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}