<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Contracts\EmulatorContract;
use App\Concerns\SkyFire\SendsIngameMails;
use Illuminate\Database\ConnectionResolver;
use App\Concerns\SkyFire\ManagesGameAccounts;
use App\Concerns\SkyFire\GathersPlayerStatistics;
use App\Concerns\SkyFire\GathersServerStatistics;
use App\Concerns\SkyFire\ResolvesDatabaseConnections;

/**
 * @todo reduce responsibilities
 * @todo trait methods into contracts
 */
class SkyFire implements EmulatorContract
{
    use ManagesGameAccounts, GathersPlayerStatistics, GathersServerStatistics, ResolvesDatabaseConnections, SendsIngameMails;

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
}
