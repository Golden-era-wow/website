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
     * Create a new job instance
     *
     * @return void
     */
    public function __construct($emulators = null)
    {
        $this->emulators = Emulator::supported();
    }

    /**
     * Execute the job.
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
                ->whereDate('updateDate', '=', Carbon::today()->toDateString())
                ->whereTime('updateDate', '>=', Carbon::now()->subMinutes(15))
                ->get()
                ->map(function ($guild) use ($emulator) {
                    $emulator
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
                        'updated_at' => $guild->updateDate
                    ];
                });

                if ($guilds->isNotEmpty()) {
                    $searchIndex->addObjects($guilds->all());
                }
        }
    }
}
