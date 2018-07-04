<?php

namespace App\Emulators;

use App\Contracts\EmulatorContract;
use App\Contracts\Emulators\ResolvesDatabaseConnections;
use Illuminate\Database\ConnectionResolver;
use Illuminate\Support\Facades\DB;

class EmulatorDatabase implements ResolvesDatabaseConnections
{
    /**
     * The Emulator instance
     *
     * @var EmulatorContract
     */
    protected $emulator;

    /**
     * The database connection resolver for the emulators tables
     *
     * @var \Illuminate\Database\ConnectionResolverInterface
     */
    protected $connectionResolver;

    /**
     * EmulatorDatabaseConnectionResolver constructor.
     *
     * @param EmulatorContract $emulator
     */
    public function __construct(EmulatorContract $emulator)
    {
        $this->emulator = $emulator;
    }

    /**
     * Get the database connection resolver
     *
     * @return \Illuminate\Database\ConnectionResolverInterface
     */
    public function connectionResolver()
    {
        if ($this->connectionResolver) {
            return $this->connectionResolver;
        }

        return $this->connectionResolver = $this->newConnectionResolver();
    }

    /**
     * Create a new database connection resolver
     *
     * @return \Illuminate\Database\ConnectionResolverInterface
     */
    public function newConnectionResolver()
    {
        return new ConnectionResolver([
            'auth' => $this->auth(),
            'characters' => $this->characters(),
            'world' => $this->world()
        ]);
    }

    /**
     * Get a auth database connection
     *
     * @return \Illuminate\Database\ConnectionInterface
     */
    public function auth()
    {
        return DB::connection(
            $this->emulator->config('db_auth')
        );
    }

    /**
     * Get a characters database connection
     *
     * @return \Illuminate\Database\ConnectionInterface
     */
    public function characters()
    {
        return DB::connection(
            $this->emulator->config('db_characters')
        );
    }

    /**
     * Get a world database connection
     *
     * @return \Illuminate\Database\ConnectionInterface
     */
    public function world()
    {
        return DB::connection(
            $this->emulator->config('db_world')
        );
    }
}
