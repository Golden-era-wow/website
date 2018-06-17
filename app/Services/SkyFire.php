<?php

namespace App\Services;

use App\Contracts\EmulatorContract;
use App\Concerns\SkyFire\SendsIngameMails;
use App\Concerns\SkyFire\ManagesGameAccounts;
use App\Concerns\SkyFire\GathersPlayerStatistics;

class SkyFire implements EmulatorContract
{
    use ManagesGameAccounts, GathersPlayerStatistics, SendsIngameMails;
}
