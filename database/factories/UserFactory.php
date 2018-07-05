<?php

use App\Jobs\CreateGameAccountJob;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
        return [
            'name' => $faker->name,
            'account_name' => $faker->username,
            'balance' => 0,
            'email' => $faker->unique()->safeEmail,
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'photo_url' => $faker->imageUrl(),
            'remember_token' => str_random(10),
        ];
    }
);

$factory->state(App\User::class, 'with game account', []);
$factory->afterCreatingState(App\User::class, 'with game account', function ($user, $faker) {
    app()->call([new CreateGameAccountJob($user, 'secret', ['SkyFire']), 'handle']);
});

$factory->state(App\User::class, 'with skyfire account', []);
$factory->afterCreatingState(App\User::class, 'with skyfire account', function ($user, $faker) {
    app()->call([new CreateGameAccountJob($user, 'secret', ['SkyFire']), 'handle']);
});

$factory->state(App\User::class, 'with cart', []);
$factory->afterCreatingState(App\User::class, 'with cart', function ($user, $faker) {
    $user->cart()->create(['user_id' => $user->id]);
});

$factory->state(App\User::class, 'with API access', []);
$factory->afterCreatingState(App\User::class, 'with API access', function ($user, $faker) {
    $clients = resolve(\Laravel\Passport\ClientRepository::class);
    $clients->create($user->id, 'testing', 'http://localhost');
    $clients->createPersonalAccessClient($user->id, 'testing', 'http://localhost');
    $user->createToken('testing', []);
});
