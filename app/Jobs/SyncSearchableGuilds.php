<?php

namespace App\Jobs;

use AlgoliaSearch\Client;
use App\Emulator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

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
     * @param \AlgoliaSearch\Client  $algolia
     * @return void
     */
    public function handle(Client $algolia)
    {
        $searchIndex = $algolia->initIndex('guilds');

        foreach ($this->emulators as $name) {
            $emulator = Emulator::driver($name);

            $guilds = $emulator
                ->guilds()
                ->when($this->onlyRecentlyUpdated, function ($query) {
                    $query
                        ->whereDate('updatedDate', '=', Carbon::today()->toDateString())
                        ->whereTime('updatedDate', '>=', Carbon::now()->subMinutes(15));
                })
                ->get()
                ->map(function ($guild) use ($emulator) {
                    $guildLeader = $emulator
                        ->characters()
                        ->table('characters')
                        ->where('guid', $guild->leaderguid)
                        ->first();

                    return [
                        'objectID' => $guild->guildid,
                        'name' => $guild->name,
                        'leader' => optional($guildLeader)->name,
                        'level' => $guild->level,
                        'rank' => $guild->rank,
                        'info' => $guild->info,
                        'created_at' => $guild->createdate,
                        'updated_at' => Carbon::parse($guild->updatedDate)->getTimestamp()
                    ];
                });

                if ($guilds->isNotEmpty()) {
                    $searchIndex->addObjects($guilds->all());
                }
        }
    }
}
