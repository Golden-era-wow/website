<?php

namespace App\Services;

use App\Services\SkyFire;
use Illuminate\Support\Manager;

class EmulatorManager extends Manager
{
    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return 'SkyFire';
    }

    public function createSkyFireDriver()
    {
        return new SkyFire;
    }
}
