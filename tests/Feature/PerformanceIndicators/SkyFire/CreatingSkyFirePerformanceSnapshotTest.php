<?php

namespace Tests\Feature\PerformanceIndicators\SkyFire;

use App\Emulators\EmulatorStatistics;
use App\Emulators\SkyFire;
use App\Repositories\IngamePerformanceIndicators;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreatingSkyFirePerformanceSnapshotTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var IngamePerformanceIndicators
     */
    protected $repository;

    public function setUp()
    {
        parent::setUp();

        $emuStats = \Mockery::mock(EmulatorStatistics::class);
        $emuStats->makePartial();

        $emuStats->shouldReceive('emulator')->andReturn(new SkyFire);
        $emuStats->shouldReceive('latency')->andReturn(100);
        $emuStats->shouldReceive('playersOnline')->andReturn(100);
        $emuStats->shouldReceive('playersTotal')->andReturn(142);
        $emuStats->shouldReceive('playersRecentlyCreated')->andReturn(10);

        $this->repository = new IngamePerformanceIndicators($emuStats);
    }

    /** @test */
    public function itCreatesASnapshotOfIngamePerformance()
    {
        $this->repository->createSnapshot();

        $this->assertDatabaseHas('emulator_performance_indicators', [
            'created_at' => now(),
            //'emulator' => SkyFire::class,
            'latency' => 100,
            'online' => 100,
            'accounts' => 142,
            'newcomers' => 10,
        ]);
    }
}
