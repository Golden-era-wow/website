<?php

namespace App;

use App\Services\EmulatorManager;
use Illuminate\Support\Facades\Facade;

class Emulator extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return EmulatorManager::class;
    }
}
