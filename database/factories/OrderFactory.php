<?php

use Faker\Generator as Faker;

$factory->define(App\Order::class, function (Faker $faker) {
    return [
        'user_id' => factory('App\User'),
        'product_id' => factory('App\Product'),
        'quantity' => $faker->numberBetween(1,100),
    ];
});
