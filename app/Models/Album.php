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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['',];

    public function artiste() 
    {
        return $this->belongsTo(User::class);
    }
}
