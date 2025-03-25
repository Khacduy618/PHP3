<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    /** @use HasFactory<\Database\Factories\TagFactory> */
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'tags';

    protected $fillable = [
        'name', 
        'slug',
    ];
    public function news(): BelongsToMany
    {
        return $this->belongsToMany(News::class, 'news_tags');
    }
}
