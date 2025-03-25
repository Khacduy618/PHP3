<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use MongoDB\Laravel\Eloquent\Casts\ObjectId;
class User extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    protected $connection = 'mongodb';
    protected $table = 'users';
    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'avatar', 
        'phone', 
        'address', 
        'role', 
        'email_verified_at', 
        'remember_token',
    ];

    public function getCast(){ 
        return [
            '_id' => ObjectId::class,
        ];
    }
}
