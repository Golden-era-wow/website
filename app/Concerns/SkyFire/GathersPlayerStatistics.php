<?php

namespace App\Concerns\SkyFire;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

trait GathersPlayerStatistics
{
    /**
     * Get the amount of online players
     *
     * @return integer
     */
    public function playersOnline()
    {
        return $this
            ->auth()
            ->table('account')
            ->where('online', '>', 0)
            ->count();
    }

    /**
     * Get the amount of active players
     *
     * @return int
     */
    public function playersActive()
    {
        return $this
            ->auth()
            ->table('account')
            ->whereDate('last_login', '>', Carbon::today()->subMonths(6)->format('Y-m-d'))
            ->count();
    }

    /**
     * Get the amount of inactive players
     *
     * @return int
     */
    public function playersInactive()
    {
        return $this
            ->auth()
            ->table('account')
            ->whereDate('last_login', '<=', Carbon::today()->subMonths(6)->format('Y-m-d'))
            ->count();
    }

    /**
     * Get the amount of players created within last month
     *
     * @return int
     */
    public function playersRecentlyCreated()
    {
        return $this
            ->auth()
            ->table('account')
            ->whereDate('joindate', '>=', Carbon::today()->subMonth()->format('Y-m-d'))
            ->count();
    }

    /**
     * Get the total amount of game accounts
     *
     * @return int
     */
    public function playersTotal()
    {
        return $this
            ->auth()
            ->table('account')
            ->count();
    }
}
