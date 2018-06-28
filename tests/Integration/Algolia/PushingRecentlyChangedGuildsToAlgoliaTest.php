<?php

namespace Tests\Feature\Integration\Algolia;

use App\User;
use App\Emulator;
use Tests\TestCase;
use Illuminate\Support\Carbon;
use App\Jobs\SyncSearchableGuilds;
use Illuminate\Support\Facades\DB;
use AlgoliaSearch\Client as Algolia;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class PushingRecentlyChangedGuildsToAlgoliaTest extends TestCase
{
    use RefreshDatabase;

    protected $connectionsToTransact = ['skyfire_characters', 'skyfire_auth'];

	protected $guilds;

	protected function setUp()
	{
		parent::setUp();

        $this->guilds = Emulator::driver('skyfire')->guilds();
	}

    /** @test */
    public function itSyncsRecentGuildsToAlgolia()
    {
        $auth = Emulator::driver('skyfire')->auth();
        $characters = Emulator::driver('skyfire')->characters();

        $realmId = $auth->table('realmlist')->insertGetId([
            'name' => 'Test realm'
        ]);

        $accountId = $auth->table('account')->insertGetId([
            'username' => 'johnDoe',
            'email' => 'john@example.com',
            'sha_pass_hash' => 'secret'
        ]);

        $characters->table('characters')->insert([
            'guid' => $characterId = $characters->table('characters')->max('guid')+1,
            'account' => $accountId,
			'name' => 'John',
			'taximask' => 0
        ]);

        $auth->table('realmcharacters')->insert([
            'realmid' => $realmId,
            'acctid' => $accountId
        ]);

        $characters->table('character_reputation')->insert([
            'guid' => $characterId,
            'faction' => 67 // 67 equals Horde
        ]);

		$this->guilds->insert([
            'guildid' => 1,
            'level' => 3,
			'name' => 'Flaming monkeys',
			'leaderguid' => $characterId,
			'info' => 'this is a test guild',
			'motd' => 'this is a test guild'
        ]);

        $characters->table('guild_achievement')->insert(['guildid' => 1, 'achievement' => 1, 'guids' => '1,2,3,4']);

		$this->guilds->insert([
			'guildid' => 2,
			'name' => 'Flying beer monsters',
			'leaderguid' => $characterId,
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
            $this->assertEquals('Horde', $searchResult[0]['faction']);
            $this->assertEquals('Test realm', $searchResult[0]['realm']);
            $this->assertEquals('John', $searchResult[0]['leader']);
            $this->assertEquals(3, $searchResult[0]['level']);
            $this->assertEquals(1, $searchResult[0]['rank']);

            $this->assertEquals(1, $searchResult[0]['objectID']);

            $this->assertEmpty($guilds->search('beer')['hits']);
            // Clean up our mess :)
            $guilds->deleteObjects([1,2]);
        });
    }
}
