<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Genre;
use Faker\Generator as Faker;

$factory->define(
    Genre::class, function (Faker $faker) {
        return [
            'title' => $faker->realText(12),
            'description' => $faker->paragraph(),
        ];
    }
);
