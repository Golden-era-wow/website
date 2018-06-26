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
    const HOST = 'game.quazye.me';
    const PORT = 8085;

    use ManagesGameAccounts, GathersPlayerStatistics, GathersServerStatistics, SendsIngameMails;

    public function findGear($id)
    {
    	return $this
            ->world()
    	    ->table('item_template')
    	    ->where('entry', $id)
    	    ->first();
    }

    public function characters()
    {
        return DB::connection('skyfire_characters');
    }

    public function auth()
    {
        return DB::connection('skyfire_auth');
    }

    public function world()
    {
        return DB::connection('skyfire_world');
    }
}
