<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Attribution;
use App\Course;
use App\Professeur;
use App\Groupe;
use Faker\Generator as Faker;

$factory->define(Attribution::class, function (Faker $faker) {
    $courses = Course::pluck('id')->toArray();
    $professors = Professeur::pluck('acronyme')->toArray();
    $groupes = Groupe::pluck('nom')->toArray();
    return [
        'professor_acronyme' => $faker->randomElement($professors),
        'course_id' => $faker->randomElement($courses),
        'group_id' => $faker->randomElement($groupes),
        'quadrimester' => $faker->numberBetween($min = 1, $max = 6),
    ];
});
