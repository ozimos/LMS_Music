<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Song;
use App\Models\Genre;
use App\Models\Album;
use Faker\Generator as Faker;

$factory->define(
    Song::class, function (Faker $faker) {

        return [
        'title' => $faker->realText(12),
        'file' => 'random/songs/new.mp3',
        'description' => $faker->paragraph(),
        'release_date' => $faker->dateTimeThisDecade(),
        'album_id' => function(){ return factory(Album::class)->create()->id;},
        'genre_id' => function(){ return factory(Genre::class)->create()->id;}
        ];
    }
);
