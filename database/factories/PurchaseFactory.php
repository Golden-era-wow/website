<?php

use Faker\Generator as Faker;

$factory->define(App\Purchase::class, function (Faker $faker) {
    return [
        'applied' => false,
        'user_id' => factory(App\User::class)->lazy(),
        'cart_id' => factory(App\Cart::class)->lazy(),
        'total_cost' => 0
    ];
});

$factory->state(App\Purchase::class, 'applied', ['applied' => true]);
