<?php

namespace App\Repositories;

use App\Contracts\Emulators\GathersGameStatistics;
use App\Emulators\EmulatorStatistics;
use Illuminate\Support\Facades\DB;

class IngamePerformanceIndicators
{
    /**
     * The emulator statistics
     *
     * @var EmulatorStatistics
     */
    protected $statistics;

    /**
     * IngamePerformanceIndicators constructor.
     *
     * @param GathersGameStatistics $statistics
     */
    public function __construct(GathersGameStatistics $statistics)
    {
        $this->statistics = $statistics;
    }

    /**
     * Create a snapshot of the ingame performance metrics
     *
     * @param \DateTime $timestamp
     * @return void
     */
    public function createSnapshot(\DateTime $timestamp = null)
    {
        $timestamp = $timestamp ?? now();

        DB::table('emulator_performance_indicators')->insert([
            'created_at' => $timestamp,
            'emulator' => get_class($this->statistics->emulator()),
            'latency' => $this->statistics->latency(),
            'online' => $this->statistics->playersOnline(),
            'accounts' => $this->statistics->playersTotal(),
            'newcomers' => $this->statistics->playersRecentlyCreated(),
        ]);
    }
}
