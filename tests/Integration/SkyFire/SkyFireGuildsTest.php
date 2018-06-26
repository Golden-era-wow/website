<?php

namespace Tests\Integration\SkyFire;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Services\SkyFire;

class SkyFireGuildsTest extends TestCase
{
	use RefreshDatabase;

    protected $connectionsToTransact = [null];

    protected $skyfire;

    protected function setUp()
    {
    	// make sure our app has been bootstrapped, so we can access the config
        if (! $this->app) {
            $this->refreshApplication();
        }

    	array_push($this->connectionsToTransact, $this->app->make('config')->get('services.skyfire.db_characters'));

    	parent::setUp();

    	$this->skyfire = $this->app->make(SkyFire::class);
    }

    /** @test */
    function itListsGuildByTheirAchievementScore() 
    {
    	$database = $this->skyfire->characters();

    	$database->table('guild')->insert([
    		'guildid' => 999,
    		'name' => 'flame eaters',
			'info' => 'this is a test guild',
			'motd' => 'this is a test guild'    		
    	]);

    	$database->table('guild')->insert([
    		'guildid' => 998,
    		'name' => 'banana tossers',
			'info' => 'this is a test guild',
			'motd' => 'this is a test guild'    		
    	]);

    	$database->table('guild_achievement')->insert([
    		'guildid' => 999,
    		'achievement' => 1,
    		'guids' => '1,2,3,4'
    	]);

    	$guilds = $this->skyfire->guildsByRank()->get();

    	$this->assertEquals($guilds[0]->name, 'flame eaters');
    	$this->assertEquals($guilds[0]->guild_achievement_count, 1);

    	$this->assertEquals($guilds[1]->name, 'banana tossers');
    	$this->assertEquals($guilds[1]->guild_achievement_count, 0);
    } 

    /** @test */
    function itListsGuildByTheirLevel() 
    {
    	$database = $this->skyfire->characters();

    	$database->table('guild')->insert([
    		'guildid' => 999,
    		'name' => 'flame eaters',
			'info' => 'this is a test guild',
			'motd' => 'this is a test guild',
			'level' => 25  		
    	]);

    	$database->table('guild')->insert([
    		'guildid' => 998,
    		'name' => 'banana tossers',
			'info' => 'this is a test guild',
			'motd' => 'this is a test guild'  ,
			'level' => 24  		
    	]);

    	$guilds = $this->skyfire->guildsByLevel()->get();
    	
    	$this->assertEquals($guilds[0]->name, 'flame eaters');
    	$this->assertEquals($guilds[0]->level, 25);

    	$this->assertEquals($guilds[1]->name, 'banana tossers');
    	$this->assertEquals($guilds[1]->level, 24);
    } 
}