<?php

use Faker\Generator as Faker;

$factory->define(App\CharacterItem::class, function (Faker $faker) {
    return [
        'item_guid' => $faker->numberBetween(1, 5),
        'photo_url' => $faker->imageUrl(),
        'description' => $faker->text
    ];
});

$factory->state(App\CharacterItem::class, 'with cost', function (Faker $faker) {
    return ['cost' => $faker->randomNumber(2)];
});
