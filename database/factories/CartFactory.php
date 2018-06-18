<?php

use Faker\Generator as Faker;

$factory->define(App\Cart::class, function (Faker $faker) {
    return [
        'user_id' => factory(App\User::class)->lazy(),
        'abandoned' => false,
        'purchased' => false
    ];
});

$factory->state(App\Cart::class, 'abandoned', ['abandoned' => true]);
$factory->state(App\Cart::class, 'purchased', ['purchased' => true]);
