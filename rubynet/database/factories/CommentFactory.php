<?php

use App\Post;
use App\User;
use App\Comment;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'content' => $faker->paragraph(1),
        'user_id' => User::all()->random()->id,
        'post_id' => Post::all()->random()->id,
    ];
});
