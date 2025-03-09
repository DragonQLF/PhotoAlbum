<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity; // Add this
use Spatie\Activitylog\LogOptions; // Add this

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'profile_picture'
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Activity log configuration
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'role'])
            ->logOnlyDirty();
    }

    // Relationship with albums (owned)
    public function albums()
    {
        return $this->hasMany(Album::class);
    }

    // Relationship for shared albums
    public function sharedAlbums()
    {
        return $this->belongsToMany(Album::class, 'album_user');
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}