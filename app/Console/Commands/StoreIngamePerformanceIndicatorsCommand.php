<?php

namespace App\Console\Commands;

use App\Emulator;
use Illuminate\Console\Command;
use App\Repositories\IngamePerformanceIndicators;

class StoreIngamePerformanceIndicatorsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emulators:kpi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Store the performance indicators for the emulators.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach(['SkyFire'] as $emulator) {
            (new IngamePerformanceIndicators(Emulator::driver($emulator)))->createSnapshot();
        }
    }
}
