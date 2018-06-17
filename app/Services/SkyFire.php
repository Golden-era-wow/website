<?php

namespace App\Services;

use App\Concerns\SkyFire\SendsIngameMails;
use App\Concerns\SkyFire\ManagesGameAccounts;
use App\Concerns\SkyFire\GathersPlayerStatistics;

class SkyFire
{
    use ManagesGameAccounts, GathersPlayerStatistics, SendsIngameMails;
}
