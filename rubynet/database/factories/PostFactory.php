<?php

use App\Post;
use App\User;
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

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(),    
        'content' => $faker->paragraph(1),
        'like_count' => $faker->numberBetween(0,100),
        'comment_count' => $faker->numberBetween(0,100),
        'user_id' => User::all()->random()->id,
    ];
});
