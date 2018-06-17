<?php

namespace App\Repositories;

use App\Emulator;
use Illuminate\Support\Facades\DB;
use App\Contracts\EmulatorContract;

class IngamePerformanceIndicators
{
    /**
     * The game emulator we're gathering statistics from
     *
     * @var \App\Contracts\EmulatorContract
     */
    protected $emulator;

    /**
     * Create a new Ingame performance indicator repository
     *
     * @param string | EmulatorContract $emulator
     */
    public function __construct($emulator)
    {
        $this->emulator = is_string($emulator) ? Emulator::driver($emulator) : $emulator;
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
            'emulator' => get_class($this->emulator),
            'latency' => $this->emulator->latency(),
            'online' => $this->emulator->playersOnline(),
            'accounts' => $this->emulator->playersTotal(),
            'newcomers' => $this->emulator->playersRecentlyCreated(),
        ]);
    }
}
