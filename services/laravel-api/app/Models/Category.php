<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'categories';

    protected $fillable = [
        'name', 
        'slug',
    ];
}
