<?php

namespace App;

use App\Services\EmulatorManager;
use Illuminate\Support\Facades\Facade;

class Emulator extends Facade
{
    /**
     * Get an array of supported emulator driver names
     *
     * @return array
     */
    public static function supported()
    {
        $reflection = new \ReflectionClass(static::getFacadeAccessor());

        $methods = collect($reflection->getMethods(\ReflectionMethod::IS_PUBLIC | \ReflectionMethod::IS_PROTECTED | \ReflectionMethod::IS_PRIVATE));

        return $methods->filter(function (\ReflectionMethod $method) {
            return starts_with($method->name, 'create')
                && ends_with($method->name, 'Driver');
        })->map(function (\ReflectionMethod $method) {
            $driver = str_after($method->name, 'create');

            return str_before($driver, 'Driver');
        })->filter()->toArray();
    }

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
