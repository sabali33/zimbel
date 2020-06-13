<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Schedule;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Schedule::class, function (Faker $faker) {
   
    return [
        'remote_schedule_id' => $faker->randomDigit,
        'api_root'  => $faker->url,
        'start_time' => $faker->dateTime,
        'start_minute' => $faker->time('i'),
        'repeat_frequency' => collect(['daily', 'weekly', 'monthly'])->random(),
        'selected_date' => collect(['time-above', 'other-times'])->random(),
        'days_of_week'  => $faker->dayOfWeek,
        'days_of_month'  => $faker->dayOfMonth,
        'hours_of_day'  => $faker->time('H'),
        'customer_id'  => factory(App\Customer::class)->create(),
        'api_key'  => Str::random(),
    ];
});
