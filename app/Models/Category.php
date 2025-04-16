<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Re-import SoftDeletes

class Category extends Model
{
    use HasFactory, SoftDeletes; // Re-add SoftDeletes trait

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'status',
        'user_id', // Added user_id
    ];

    // Quan hệ với chính bảng categories (danh mục cha)
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Quan hệ với chính bảng categories (danh mục con)
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Quan hệ với bảng news
    public function news()
    {
        return $this->hasMany(News::class);
    }
}
