<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Attribution;
use Faker\Generator as Faker;

$factory->define(Attribution::class, function (Faker $faker) {
    return [
        'id' => $faker->numerify('#####'),
        'professor_acronyme' => factory(App\Professeur::class),
        'course_id' => factory(App\Course::class),
        'group_id' => factory(App\Groupe::class),
        'quadrimester'=> $faker->numberBetween($min = 1, $max = 6),
    ];
});
