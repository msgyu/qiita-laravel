<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\like;
use App\Models\post;
use Faker\Generator as Faker;

$factory->define(like::class, function (Faker $faker) {
    $postIDs  = App\Models\post::pluck('id')->all();
    $userIDs  = App\User::pluck('id')->all();
    return [
        'post_id' => $faker->randomElement($postIDs),
        'user_id' => $faker->randomElement($userIDs),
    ];
});
