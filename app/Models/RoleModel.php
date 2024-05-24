<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    use HasFactory;
    protected $table = 'roles';
    protected $fillable = [
        "name",
        "description",
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function rolePermission()
    {
        return $this->hasMany(RolePermissionModel::class);
    }
}
