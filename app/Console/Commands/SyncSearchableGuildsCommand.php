<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SyncSearchableGuilds;

class SyncSearchableGuildsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'guilds:searchable {emulator?} {--all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make ingame guilds searchable.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        dispatch(new SyncSearchableGuilds(
            $this->argument('emulator'),
            $this->option('all')
        ));
    }
}
