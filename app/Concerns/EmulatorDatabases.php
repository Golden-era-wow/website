<?php

namespace App\Concerns;

use App\Emulator;

trait EmulatorDatabases
{
    public static function bootEmulatorDatabases()
    {
        static::setConnectionResolver(
            Emulator::databaseConnectionResolver()
        );
    }

    public static function makeWithEmulator(EmulatorContract $emulator, array $attributes = [])
    {
        static::setConnectionResolver($emulator->databaseConnectionResolver());

        return new static($attributes);
    }

    public static function createWithEmulator(EmulatorContract $emulator, array $attributes = [])
    {
        return tap(static::makeWithEmulator($emulator, $attributes), function ($model) {
            $model->saveOrFail();
        });
    }
}
