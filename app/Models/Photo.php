<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'is_public',
        'description',
        'user_id',
        'album_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function album()
    {
        return $this->belongsTo(Album::class, 'album_id', 'id');
    }
    public function comments()
    {
        return $this->hasMany(PhotoComment::class, 'photo_id', 'id');
    }
    public function likes()
    {
        return $this->hasMany(PhotoLike::class, 'photo_id', 'id');
    }
}
