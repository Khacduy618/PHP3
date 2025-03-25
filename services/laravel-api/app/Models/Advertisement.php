<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Advertisement extends Model
{
    /** @use HasFactory<\Database\Factories\AdvertisementFactory> */
    use HasFactory;
    protected $connection = 'mongodb';
    protected $table = 'advertisements';

    protected $fillable = [
        'title', 
        'image', 
        'url', 
        'position',
    ];
}
