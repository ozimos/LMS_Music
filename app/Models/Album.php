<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Album.
 *
 * @package namespace App\Models;
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

    public function artiste() 
    {
        return $this->belongsTo(User::class);
    }
}
