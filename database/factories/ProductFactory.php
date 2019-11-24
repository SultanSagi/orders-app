<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    $discountActive = $faker->boolean;
    return [
        'name' => $faker->name,
        'price' => $faker->numberBetween(1,100) * 100,
        'discount' => $discountActive ? $faker->numberBetween(1,20)*5 : null,
    ];
});
