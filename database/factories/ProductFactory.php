<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'title' => $faker->word(10),
        'description' => $faker->text(50),
        'user_id' => factory(App\User::class)->create(),
        'link' => $faker->url,
        'price' => $faker->randomFloat(2, 20, 200)
    ];
});
