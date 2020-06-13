<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\License;
use Faker\Generator as Faker;

$factory->define(License::class, function (Faker $faker) {
    return [
        'customer_id' => factory(App\Customer::class)->create(),
        'product_id' => factory(App\Product::class)->create(),
        'license_key' => Str::random(),
        'expiry_date' => $faker->dateTimeInInterval('now', '+1 year')
    ];
});
