<?php

use App\User;
use App\Department;
use App\DepartmentManager;
use Faker\Generator as Faker;

$factory->define(DepartmentManager::class, function (Faker $faker) {
    return [
        'department_id' => Department::all()->random()->id,
        'manager_id' => User::all()->random()->id,
        'managed_from' => $faker->date,
        'managed_to' => $faker->date,
    ];
});
