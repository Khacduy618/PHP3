<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // Import BelongsToMany

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'avatar',
        'password',
        'remember_token',
        'email_verified_at',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function news()
    {
        return $this->hasMany(News::class);
    }


    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Get the comments for the user.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * The comments that the user has liked.
     */
    public function likedComments(): BelongsToMany
    {
        return $this->belongsToMany(Comment::class, 'comment_like', 'user_id', 'comment_id')->withTimestamps();
    }

    /**
     * The news articles that the user has liked.
     */
    public function likedNews(): BelongsToMany
    {
        return $this->belongsToMany(News::class, 'likes', 'user_id', 'news_id')->withTimestamps();
    }
}
