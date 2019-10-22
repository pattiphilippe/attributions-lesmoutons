<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Professeur;
use Faker\Generator as Faker;

$factory->define(Professeur::class, function (Faker $faker) {
    return [
        'acronyme' => $faker->unique()->lexify('???'),
        'nom' =>  $faker->firstname,
        'prenom' => $faker->lastname
    ];
});
