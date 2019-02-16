<?php

use App\Models\Company;
use App\Models\Station;
use Faker\Generator as Faker;
use Grimzy\LaravelMysqlSpatial\Types\Point;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Station::class, function (Faker $faker) {
    return [
        'name' => $faker->streetName,
        'location' => new Point(
            $faker->randomFloat(6, 35.670106, 35.755129),
            $faker->randomFloat(6, 51.316461, 51.489839)
        ),
    ];
});

$factory->state(Station::class, 'with-company', function () {
    return [
        'company_id' => Company::query()->inRandomOrder()->firstOrCreate(factory(Company::class)->make()->toArray())->id,
    ];
});
