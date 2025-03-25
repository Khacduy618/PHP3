<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class News extends Model
{
    /** @use HasFactory<\Database\Factories\NewsFactory> */
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'news';

    protected $fillable = [
        'user_id', 
        'title', 
        'slug', 
        'summary', 
        'content', 
        'thumbnail', 
        'category_id', 
        'views', 
        'status',
    ];
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'news_tags');
    }
}
