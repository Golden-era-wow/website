<?php

namespace App\Jobs;

use App\Guild;
use App\Emulator;
use AlgoliaSearch\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

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
     * @param array $emulators
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
                ->with('leader')
                ->withRank()
                ->withFaction()
                ->when($this->onlyRecentlyUpdated, function ($guilds) {
                    $guilds->recent();
                })->searchable();
        }
    }
}
