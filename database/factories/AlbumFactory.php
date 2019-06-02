<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Album;
use App\User;
use Faker\Generator as Faker;

$factory->define(
    Album::class, function (Faker $faker) {
        return [
            'title' => $faker->realText(12),
            'description' => $faker->paragraph(),
            'release_date' => $faker->dateTimeThisDecade(),
            'image' => $faker->imageUrl(),
            'user_id' => function () {
                return factory(User::class)->create()->id;
            },
        ];
    }
);
