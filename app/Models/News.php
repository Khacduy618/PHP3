<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // Import BelongsToMany
use Illuminate\Database\Eloquent\SoftDeletes; // Re-import SoftDeletes

class News extends Model
{
    use HasFactory, SoftDeletes; // Re-add SoftDeletes trait

    protected $fillable = [
        'title',
        'content',
        'summary',
        'slug',
        'views',
        'image',
        'status',
        'tags', // Corrected typo: tag -> tags
        'is_hot',
        'is_featured',
        'is_trending',
        'category_id',
        'user_id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        // 'tags' => 'array', // Removed cast - will handle manually in controller/views
        // Cast boolean flags for easier handling
        'is_hot' => 'boolean',
        'is_featured' => 'boolean',
        'is_trending' => 'boolean',
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

    /**
     * Get the comments for the news article.
     */
    public function comments(): HasMany
    {
        // Get only top-level comments (not replies)
        // Eager load user and replies (with their users) for efficiency
        return $this->hasMany(Comment::class)
            ->whereNull('parent_id') // Only top-level comments
            ->with(['user', 'replies.user']) // Eager load nested relationships
            ->latest(); // Order newest comments first
    }

    /**
     * The users that liked the news article.
     */
    public function likers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'likes', 'news_id', 'user_id')->withTimestamps();
    }
}
