<?php

namespace App\Services;

use App\Concerns\SkyFire\GathersPlayerStatistics;
use App\Concerns\SkyFire\GathersServerStatistics;
use App\Concerns\SkyFire\ManagesGameAccounts;
use App\Concerns\SkyFire\SendsIngameMails;
use App\Contracts\EmulatorContract;
use Illuminate\Support\Facades\DB;

class SkyFire implements EmulatorContract
{
    use ManagesGameAccounts, GathersPlayerStatistics, GathersServerStatistics, SendsIngameMails;

    public function findGear($id)
    {
    	return $this
            ->world()
    	    ->table('item_template')
    	    ->where('entry', $id)
    	    ->first();
    }

    /**
     * Get a config value
     *
     * @param  string|null $key
     * @return string|array|null
     */
    public function config($key = null)
    {
        return array_get(config('services.skyfire'), $key);
    }

    public function guilds()
    {
        return $this
            ->characters()
            ->table('guild')
            ->select(['*'])
            ->selectSub('SELECT count(*) FROM guild_achievement WHERE guild.guildid = guildid', 'rank')
            ->selectSub('SELECT faction FROM character_reputation WHERE guild.leaderguid = guid', 'faction');
    }

    /**
     * Get the name for given faction id
     *
     * @param integer $id
     * @return string
     */
    public function faction(int $id)
    {
        $factions = [
            67 => 'Horde',
            469 => 'Alliance'
        ];

        return $factions[$id] ?? 'Unknown';
    }

    public function characters()
    {
        return DB::connection(
            $this->config('db_characters')
        );
    }

    public function auth()
    {
        return DB::connection(
            $this->config('db_auth')
        );
    }

    public function world()
    {
        return DB::connection(
            $this->config('db_world')
        );
    }
}
