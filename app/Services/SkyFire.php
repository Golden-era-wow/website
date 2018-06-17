<?php

namespace App\Services;

use App\Concerns\SkyFire\SendsIngameMails;
use App\Concerns\SkyFire\ManagesGameAccounts;

class SkyFire
{
    use ManagesGameAccounts, SendsIngameMails;
}
