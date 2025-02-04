<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'path', 
        'description',
        'album_id'
    ];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    // Accessor para data formatada
    public function getUploadedAtAttribute()
    {
        return $this->created_at ? $this->created_at->format('M d, Y \a\t h:i A') : null;
    }
}
