<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Course;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Course::class, function (Faker $faker) {
    return [
        'id' => $faker->unique()->asciify('*****'),
        'title' =>$faker->unique()->asciify('********************'),
        'credits' =>$faker->numberBetween($min = 1, $max = 30),
        'bm1_hours' =>$faker->numberBetween($min = 1, $max = 225),// stage 450 pour un quadri
        'bm2_hours' =>$faker->numberBetween($min = 1, $max = 225),
    ];
});