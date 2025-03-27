<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'summary',
        'slug',
        'views',
        'image',
        'status',
        'category_id',
        'user_id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        // existing casts
        'created_at' => 'datetime',
    ];

    // Quan hệ với bảng categories
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Quan hệ với bảng users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với bảng comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
