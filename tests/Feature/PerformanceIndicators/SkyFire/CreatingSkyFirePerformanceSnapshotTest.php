<?php

namespace Tests\Feature\PerformanceIndicators\SkyFire;

use App\Repositories\IngamePerformanceIndicators;
use App\Services\SkyFire;
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

        $emulator = \Mockery::mock(SkyFire::class);
        $emulator->makePartial();

        $emulator->shouldReceive('latency')->andReturn(100);
        $emulator->shouldReceive('playersOnline')->andReturn(100);
        $emulator->shouldReceive('playersTotal')->andReturn(142);
        $emulator->shouldReceive('playersRecentlyCreated')->andReturn(10);
        $this->repository = new IngamePerformanceIndicators($emulator);
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
