<?php

namespace Tests\Feature\API\Guilds;

use App\Emulator;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Passport;
use Tests\TestCase;

/**
 * Refactor to using Algolia
 */
class ListingGuildsTest extends TestCase
{
	use RefreshDatabase;

	protected $connectionsToTransact = ['skyfire_characters'];

	protected $guilds;

	protected function setUp()
	{
		parent::setUp();

		$this->guilds = Emulator::driver('skyfire')->guilds();
	}

	/** @test */
	function itListsTheLatestGuildsByDefault() 
	{
		Emulator::driver('skyfire')
			->characters()
			->table('characters')
			->insert([
				'guid' => 1234,
				'name' => 'John',
				'taximask' => 0
			]);

		$this->guilds->insert([
			'guildid' => $this->guilds->max('guildid') +1,
			'name' => 'Flaming monkeys',
			'leaderguid' => 1234,
			'info' => 'this is a test guild',
			'motd' => 'this is a test guild',
			'createdate' => Carbon::parse('2018-04-29')->getTimestamp()   
		]);

		$this->guilds->insert([
			'guildid' => $this->guilds->max('guildid') +1,
			'name' => 'Flying beer monsters',
			'leaderguid' => 1234,
			'info' => 'this is a test guild',
			'motd' => 'this is a test guild',
			'createdate' => Carbon::parse('2018-04-30')->getTimestamp()   
		]);

		Passport::actingAs(
			factory(User::class)->create(),
			['list-guilds']
		);

		$data = $this->json('GET', '/api/guilds')
			->assertSuccessful()
			->json();

		$this->assertEquals('Flaming monkeys', $data[0]['name']);
		$this->assertEquals('John', $data[0]['leader']);
		$this->assertEquals('2018-04-29 00:00:00', $data[0]['created_at']);

		$this->assertEquals('Flying beer monsters', $data[1]['name']);
		$this->assertEquals('John', $data[1]['leader']);
		$this->assertEquals('2018-04-30 00:00:00', $data[1]['created_at']);
	}

	/** @test */
	function itListsGuildsByRank() 
	{
		
	} 
}
