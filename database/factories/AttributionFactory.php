<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Attribution;
use App\Course;
use App\Groupe;
use App\Professeur;
use Faker\Generator as Faker;

$factory->define(Attribution::class, function (Faker $faker) {
    return [
        'professor_acronyme' => factory(App\Professeur::class),
        'course_id' => factory(App\Course::class),
        'group_id' => factory(App\Groupe::class),
        'quadrimester' => $faker->numberBetween($min = 1, $max = 6),
    ];
});

/**
 * Picks random primary keys in the child tables for this Model fields.
 */
$factory->state(Attribution::class, 'randomForeignKeys', function (Faker $faker) {
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
