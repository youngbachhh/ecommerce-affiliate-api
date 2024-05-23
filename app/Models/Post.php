<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Illuminate\Validation\ValidationException;

class Post extends Model
{
    use HasFactory, Searchable;


    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            // Ensure priority_status is ["tăng chào", "giảm chào", "quy hoạch", "hot"]
            // if (!in_array($model->priority_status, ["tăng chào", "giảm chào", "quy hoạch", "hot"])) {
            //     throw ValidationException::withMessages(['priority_status' => 'Invalid priority_status']);
            // }
        });
    }


    protected $fillable = [
        'title',
        'description',
        'address',
        'address_detail',
        'direction',
        'area',
        'price',
        'unit',
        'sold_status',
        'status_id',
        'priority_status',
        'user_id',
    ];

    public function searchableAs(): string
    {
        return 'posts_index';
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'address' => $this->address,
            'address_detail' => $this->address_detail,
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function comment()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    public function postImage()
    {
        return $this->hasMany(PostImage::class, 'post_id', 'id');
    }
}
