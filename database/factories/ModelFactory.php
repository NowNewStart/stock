<?php
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name'           => $faker->firstName,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});
$factory->define(App\Company::class, function (Faker\Generator $faker) {
    $name = $faker->firstName;
    $shares = $faker->numberBetween(1000, 1000000);

    return [
        'name'                => $name,
        'identifier'          => strtoupper(substr($name, 0, 4)),
        'shares'              => $shares,
        'free_shares'         => $shares,
        'value'               => $faker->randomDigitNotNull,
    ];
});
