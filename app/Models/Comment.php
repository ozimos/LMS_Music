<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment.
 *
 * @package namespace App\Models;
 */
final class Comment extends Model
{
    protected $fillable = ['content', 'user_id'];
    protected $casts = ['user_id' => 'integer'];
    public function user() 
    {
        return $this->belongsTo(User::class);
    }
}
