<?php

namespace App\Concerns\SkyFire;

trait GathersServerStatistics
{
    /**
     * Determine latency to the server by measuring the time spent on establishing a socket connection to the server
     *
     * @return null | integer
     */
    public function latency()
    {
        $start = microtime(true);
        $connected = @fsockopen(static::HOST, static::PORT);

        if (! $connected) {
            return null;
        }

        return round((microtime(true) - $start) * 1000);
    }
}
