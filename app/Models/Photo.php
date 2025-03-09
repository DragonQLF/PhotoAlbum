<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Photo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'path', 
        'description',
        'album_id'
    ];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    // Accessor for formatted date
    public function getUploadedAtAttribute()
    {
        return $this->created_at ? $this->created_at->format('M d, Y \a\t h:i A') : null;
    }
}
