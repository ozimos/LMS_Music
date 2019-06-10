<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Profile.
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
