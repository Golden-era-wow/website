<?php

namespace App\Concerns;

use App\Contracts\EmulatorContract;
use App\Emulator;

trait EmulatorDatabases
{
    public static function bootEmulatorDatabases()
    {
        static::setConnectionResolver(
            Emulator::database()->connectionResolver()
        );
    }

    public static function makeWithEmulator(EmulatorContract $emulator, array $attributes = [])
    {
        static::setConnectionResolver($emulator->database()->connectionResolver());

        return new static($attributes);
    }

    public static function createWithEmulator(EmulatorContract $emulator, array $attributes = [])
    {
        return tap(static::makeWithEmulator($emulator, $attributes), function ($model) {
            $model->saveOrFail();
        });
    }
}
