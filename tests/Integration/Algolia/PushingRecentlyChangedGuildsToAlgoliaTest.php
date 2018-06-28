<?php

namespace Tests\Feature\Integration\Algolia;

use App\Emulator;
use AlgoliaSearch\Client as Algolia;
use Tests\TestCase;
use Illuminate\Support\Carbon;
use App\Jobs\SyncSearchableGuilds;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class PushingRecentlyChangedGuildsToAlgoliaTest extends TestCase
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
    public function itSyncsRecentGuildsToAlgolia()
    {
		Emulator::driver('skyfire')
			->characters()
			->table('characters')
			->insert([
				'guid' => 1,
				'name' => 'John',
				'taximask' => 0
			]);

		$this->guilds->insert([
			'guildid' => 1,
			'name' => 'Flaming monkeys',
			'leaderguid' => 1,
			'info' => 'this is a test guild',
			'motd' => 'this is a test guild'
		]);

		$this->guilds->insert([
			'guildid' => 2,
			'name' => 'Flying beer monsters',
			'leaderguid' => 1,
			'info' => 'this is a test guild',
			'motd' => 'this is a test guild',
			'updatedDate' => '2018-04-29'
        ]);

        dispatch(new SyncSearchableGuilds('SkyFire'));

        tap($this->app->make(Algolia::class)->initIndex('guilds'), function ($guilds) {
            // No search results?!
            // can't be right. Infinite loop that shit until it works.
            // or dies, horribly.
            do {
                $searchResult = $guilds->search('Flaming')['hits'];
            } while(empty($searchResult));

            $this->assertEquals('Flaming monkeys', $searchResult[0]['name']);
            $this->assertEquals(1, $searchResult[0]['objectID']);


            $this->assertEmpty($guilds->search('beer')['hits']);
            // Clean up our mess :)
            $guilds->deleteObjects([1,2]);
        });
    }
}
