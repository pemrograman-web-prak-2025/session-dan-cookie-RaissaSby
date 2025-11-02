<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relationship dengan tasks
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // Method untuk generate remember token
    public function generateRememberToken()
    {
        $this->remember_token = \Illuminate\Support\Str::random(60);
        $this->save();
        
        return $this->remember_token;
    }
}