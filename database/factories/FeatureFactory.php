<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Feature;
use Faker\Generator as Faker;

$factory->define(Feature::class, function (Faker $faker) {
    return [
        'name' => $faker->text(50),
        'alias' => $faker->text(50),
        'product_id' => factory(App\Product::class)->create(),
    ];
});
