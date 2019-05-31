<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Profile;
use Faker\Generator as Faker;

$factory->define(
    Profile::class, function (Faker $faker) {
        return [
        'content' => $faker->randomHtml(2, 3),
        'website' => $faker->url,
        'twitter' => $faker->userName,
        'facebook' => $faker->userName,
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        ];
    }
);
