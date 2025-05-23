<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image',
        'bio',
        'birthday',
        'gender',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public function photos()
    {
        return $this->hasMany(Photo::class, 'user_id', 'id');
    }
    public function albums()
    {
        return $this->hasMany(Album::class, 'user_id', 'id');
    }
    public function comments()
    {
        return $this->hasMany(PhotoComment::class, 'user_id', 'id');
    }
    public function likes()
    {
        return $this->hasMany(PhotoLike::class, 'user_id', 'id');
    }
}
