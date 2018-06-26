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
