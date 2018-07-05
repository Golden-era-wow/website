<?php

namespace App\Jobs;

use App\Emulator;
use App\Guild;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncSearchableGuilds implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The emulators to sync guilds from
     *
     * @var array
     */
    public $emulators = [];

    /**
     * Whether we should sync all or only the most recent guilds.
     *
     * @var bool
     */
    public $onlyRecentlyUpdated;

    /**
     * Create a new job to sync the guilds to Algolia.
     *
     * @param string|array $emulators
     * @param boolean $onlyRecentlyUpdated
     */
    public function __construct($emulators = null, $onlyRecentlyUpdated = true)
    {
        if ($emulators) {
            $this->emulators = array_wrap($emulators);
        } else {
            $this->emulators = Emulator::supported();
        }

        $this->onlyRecentlyUpdated = $onlyRecentlyUpdated;
    }

    /**
     * Send the guilds to Algolia
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->emulators as $name) {
            $emulator = Emulator::driver($name);

            Guild::makeWithEmulator($emulator)
                ->with(['leader', 'leader.reputation' => function ($q) {
                    $q->first();
                }])
                ->withRank()
                ->when($this->onlyRecentlyUpdated, function ($guilds) {
                    $guilds->recent();
                })->searchable();
        }
    }
}
