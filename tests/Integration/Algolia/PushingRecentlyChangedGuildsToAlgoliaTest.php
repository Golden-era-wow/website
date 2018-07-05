<?php

namespace Tests\Feature\Integration\Algolia;

use AlgoliaSearch\Client as Algolia;
use App\Account;
use App\Character;
use App\CharacterReputation;
use App\Guild;
use App\GuildAchievement;
use App\Realm;
use App\RealmCharacter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\SyncSearchToAlgolia;
use Tests\TestCase;


class PushingRecentlyChangedGuildsToAlgoliaTest extends TestCase
{
    use RefreshDatabase, SyncSearchToAlgolia;

    protected $connectionsToTransact = ['skyfire_characters', 'skyfire_auth'];

    /**
     * @test
     * @todo refactor into model factories
     */
    public function itSyncsRecentGuildsToAlgolia()
    {
        $realm = Realm::create(['name' => 'Test realm']);

        $account = Account::create([
            'username' => 'johnDoe',
            'email' => 'john@example.com',
            'sha_pass_hash' => 'secret'
        ]);

        $character = Character::createForAccount($account, [
            'name' => 'John',
            'taximask' => 0
        ]);

        RealmCharacter::create([
            'realmid' => $realm->getKey(),
            'acctid' => $account->getKey(),
        ]);

        CharacterReputation::create([
            'guid' => $character->getKey(),
            'faction' => 67 // 67 equals Horde
        ]);

        Guild::create([
            'guildid' => 1,
            'level' => 3,
			'name' => 'Flaming monkeys',
            'leaderguid' => $character->getKey(),
			'info' => 'this is a test guild',
			'motd' => 'this is a test guild'
        ]);

        GuildAchievement::create(['guildid' => 1, 'achievement' => 1, 'guids' => '1,2,3,4']);

        Guild::create([
			'guildid' => 2,
			'name' => 'Flying beer monsters',
            'leaderguid' => $character->getKey(),
			'info' => 'this is a test guild',
			'motd' => 'this is a test guild',
			'updatedDate' => '2018-04-29'
        ]);

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
