<?php

use Faker\Generator as Faker;

$factory->define(App\News::class, function (Faker $faker) {
    return [
        'creator_id' => factory(App\User::class)->lazy(),
        'photo_url' => $faker->imageUrl(),
        'title' => $faker->bs,
        'summary' => $faker->bs,
        'body' => $faker->randomHtml()
    ];
});
