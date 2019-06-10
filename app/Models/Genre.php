<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Genre.
 */
final class Genre extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'description'];
}
