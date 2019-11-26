<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Groupe;
use Faker\Generator as Faker;

$factory->define(Groupe::class, function (Faker $faker) {
    return [
        'nom' => $faker->unique()->regexify('[A-Za-z0-9]{5}'),
    ];
});
