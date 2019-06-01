<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Rating.
 *
 * @package namespace App\Models;
 */
final class Rating extends Model
{
    
    protected $casts = ['stars' => 'integer'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['stars', 'content'];

}
