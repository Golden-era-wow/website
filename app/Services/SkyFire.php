<?php

namespace App\Services;

use App\Contracts\EmulatorContract;
use App\Concerns\SkyFire\SendsIngameMails;
use App\Concerns\SkyFire\ManagesGameAccounts;
use App\Concerns\SkyFire\GathersPlayerStatistics;
use App\Concerns\SkyFire\GathersServerStatistics;

class SkyFire implements EmulatorContract
{
    const HOST = 'game.quazye.me';
    const PORT = 8085;

    use ManagesGameAccounts, GathersPlayerStatistics, GathersServerStatistics, SendsIngameMails;
}
