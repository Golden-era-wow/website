<?php

namespace Tests\Feature\User;

use App\Emulator;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FetchingCurrentUserTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	function itReturnsTheCurrentUser() 
	{
		$this->actingAs(factory(User::class)->create(['email' => 'john@example.com']), 'api');

		$this
			->json('GET', '/api/current-user')
			->assertSuccessful()
			->assertSee('john@example.com');
	} 

	/** @test */
	function itEagerLoadsRequestedRelationsOntoTheUser() 
	{
		$this->actingAs(
			$user = factory(User::class)->states(['with cart'])->create(),
			'api'
		);

		$user->gameAccounts()->create([
			'emulator' => 'testing',
			'account_id' => 1,
			'user_id' => $user->id
		]);

		$this
			->json('GET', '/api/current-user', ['with' => ['cart', 'game_accounts']])
			->assertSuccessful()
			->assertJsonFragment([
				'emulator' => 'testing',
				'account_id' => 1,
				'user_id' => $user->id
			])
			->assertJsonFragment([
				'cart' => $user->cart->toArray()
			]);
	} 
}
