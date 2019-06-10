<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\User;
use App\Models\Comment;
use Faker\Generator as Faker;

$factory->define(
    Comment::class, function (Faker $faker) {
        return [
        'content' => $faker->sentence,
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        ];
    }
);
