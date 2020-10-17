<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\post;
use Faker\Generator as Faker;

$factory->define(post::class, function (Faker $faker) {
    $userIDs  = App\User::pluck('id')->all();
    return [];
});
