<?php

use App\Job;
use App\Role;
use App\User;
use App\Department;
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

$factory->define(User::class, function (Faker $faker) {
	static $password,$verified,$admin;

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'first_name_kana'=> $faker->firstName,
        'last_name_kana'=> $faker->lastName,
        'nick_name'=> $faker->firstName,
        'current_job'=> $faker->word,
        'former_job'=> $faker->word,
        'hobbies'=> $faker->word,
        'location'=> $faker->word,
        'birth_place'=> $faker->word,
        'student_circles'=> $faker->word,
        'one_word'=> $faker->word,
        'picture' => $faker->randomElement(['man.jpg','woman1.jpg','woman2.jpg']),
        'description' => $faker->paragraph(1),
        'entry_date' => $faker->date,
        'date_of_birth' => $faker->date,
        'internal_phone_number' => $faker->numberBetween(100,300),
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'), //secret
        'remember_token' => str_random(10),
        'verified' => $verified = $faker-> randomElement([User::VERIFIED_USER, User::UNVERIFIED_USER]),
        'verification_token' => $verified == User::VERIFIED_USER ? null : User::generateVerificationCode(),
        'admin' => $admin = $faker->randomElement([User::ADMIN_USER, User::REGULAR_USER]), 
        'department_id' =>  Department::all()->random()->id,
        'role_id' =>  Role::all()->random()->id,  
        'job_id' =>  Job::all()->random()->id, 
    ];
});
