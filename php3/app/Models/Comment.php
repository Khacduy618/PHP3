<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'user_id',
        'news_id',
        'parent_id',
        'status',
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

    // Quan hệ với chính bảng comments (bình luận cha)
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    // Quan hệ với chính bảng comments (bình luận con)
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
