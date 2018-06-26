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
        $connected = @fsockopen($this->config('host'), $this->config('port'));

        if (! $connected) {
            return null;
        }

        return round((microtime(true) - $start) * 1000);
    }
}
