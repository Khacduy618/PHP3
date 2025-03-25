<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'comments';

    protected $fillable = [
        'user_id', 
        'news_id', 
        'content', 
        'is_approved',
    ];
}
