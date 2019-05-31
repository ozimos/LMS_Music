<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

/**
 * Class Profile.
 *
 * @package namespace App\Models;
 */
final class Profile extends Model
{
    protected $casts = ['user_id' => 'integer'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['content', 'user_id', 'website', 'twitter', 'facebook', 'instagram'];
    public function artiste() 
    {
        return $this->belongsTo(User::class);
    }
}
