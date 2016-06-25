<?php

$factory->define(App\Models\Job::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->jobTitle,
        'description' => $faker->paragraph,
        'user_email' => $faker->safeEmail,
        'job_access_token' => str_random(20),
    ];
});