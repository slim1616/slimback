<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Employe;
use Faker\Generator as Faker;

$factory->define(Employe::class, function (Faker $faker) {
    return [


        'prenom' => $faker->name,
        'nom' => $faker->lastname,
        'matricule' => $faker->jobTitle,
        'email' => $faker->unique()->safeEmail,
        'birthday' => $faker->dateTimeThisCentury->format('Y-m-d'),
        'active' => 1,
        'departement_id' => 1
        //'email_verified_at' => now(),

    ];
});

