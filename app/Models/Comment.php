<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // Import BelongsToMany

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'news_id',
        'parent_id',
        'content',
    ];

    /**
     * Get the user that owns the comment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the news article that the comment belongs to.
     */
    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class);
    }

    /**
     * Get the replies for the comment.
     */
    public function replies(): HasMany
    {
        // A comment has many replies (comments whose parent_id is this comment's id)
        // Order replies by oldest first
        return $this->hasMany(Comment::class, 'parent_id')->oldest();
    }

    /**
     * Get the parent comment (if this is a reply).
     */
    public function parent(): BelongsTo
    {
        // A reply belongs to a parent comment
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * The users that liked the comment.
     */
    public function likers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'comment_like', 'comment_id', 'user_id')->withTimestamps();
    }
}
