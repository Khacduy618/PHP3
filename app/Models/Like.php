<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // ID người dùng thích
        'news_id', // ID bài viết được thích
    ];

    // Quan hệ với bảng users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với bảng news
    public function news()
    {
        return $this->belongsTo(News::class);
    }

}
