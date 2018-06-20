<?php

use App\ProductCategory;
use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
    	'category' => $faker->word,
    	'type' => $faker->word,
    	'cost' => $faker->randomNumber(2),
    	'photo_url' => $faker->imageUrl,
    	'description' => $faker->bs,
       	'emulator' => null,
    	'reference' => null
    ];
});

$factory->state(App\Product::class, 'with cost', function (Faker $faker) {
    return ['cost' => $faker->randomNumber(2)];
});

$factory->state(App\Product::class, 'gear', function ($faker) {
	return [
		'category' => ProductCategory::GEAR,
		'type' => $faker->randomElement(['armor', 'weapon'])
	];
});	
