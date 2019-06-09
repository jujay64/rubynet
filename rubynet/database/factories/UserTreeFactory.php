<?php

use App\User;
use App\UserTree;
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

$factory->define(UserTree::class, function (Faker $faker) {
	$user = User::all()->random();
    $manager = User::all()->except($user->id)->random();

    return [
        'left' => $faker->numberBetween(1,10),
        'right' => $faker->numberBetween(1,10),
        'user_id' =>$user->id,
        'manager_id' => $faker->randomElement([NULL,$manager->id]),   
    ];
});
