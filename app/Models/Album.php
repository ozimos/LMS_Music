<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Album.
 */
final class Album extends Model
{
    protected $casts = ['user_id' => 'integer'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'description', 'release_date', 'image', 'user_id', 'genre_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getArtisteAttribute()
    {
        return $this->user->profile;
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class)
            ->withDefault();
    }

    public function songs()
    {
        return $this->hasMany(Song::class);
    }
}
