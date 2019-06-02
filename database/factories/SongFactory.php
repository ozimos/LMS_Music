<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Song;
use App\Models\Genre;
use App\Models\Album;
use App\User;
use Faker\Generator as Faker;

$factory->define(
    Song::class, function (Faker $faker) {
        return [
        'title' => $faker->realText(12),
        'file' => $faker->url,
        'description' => $faker->paragraph(),
        'release_date' => $faker->dateTimeThisDecade(),
        // 'album_id' => function(){ return factory(Album::create()->id);},
        // 'genre_id' => function(){ return factory(Genre::create()->id);}
        ];
    }
);
