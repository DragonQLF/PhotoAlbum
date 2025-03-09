<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Album extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'is_public',
    ];

    // Relationship with User (owner)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Photos (ADDED MISSING PHOTOS RELATIONSHIP)
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    // Relationship for shared users
    public function sharedWith()
    {
        return $this->belongsToMany(User::class, 'album_user');
    }

    public function isOwnedBy(User $user)
    {
        return $this->user_id === $user->id;
    }
}