<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // added manually
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /** Relationships **/

    // One user can make many posts
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // One user can write many comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /** Helper **/
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isModerator(): bool
    {
        return $this->role === 'moderator';
    }

    public function canModerate(): bool
    {   
        return $this->isAdmin() || $this->isModerator();    
    }
}
