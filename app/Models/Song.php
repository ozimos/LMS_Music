<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Song.
 */
final class Song extends Model
{
    protected $casts = [
        'genre_id' => 'integer',
        'album_id' => 'integer',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'description', 'release_date', 'genre_id', 'file'];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function getArtisteAttribute()
    {
        return $this->album->artiste;
    }
}
