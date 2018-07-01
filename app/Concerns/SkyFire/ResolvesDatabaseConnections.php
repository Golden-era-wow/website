<?php

namespace App\Concerns\SkyFire;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\ConnectionResolver;

trait ResolvesDatabaseConnections
{
    /**
     * The database connection resolver for the emulators tables
     *
     * @var \Illuminate\Database\ConnectionResolverInterface
     */
    protected $connectionResolver;

    /**
     * Get the database connection resolver
     *
     * @return \Illuminate\Database\ConnectionResolverInterface
     */
    public function databaseConnectionResolver()
    {
        if ($this->connectionResolver) {
            return $this->connectionResolver;
        }

        return $this->connectionResolver = $this->newDatabaseConnectionResolver();
    }

    /**
     * Create a new database connection resolver
     *
     * @return \Illuminate\Database\ConnectionResolverInterface
     */
    public function newDatabaseConnectionResolver()
    {
        return new ConnectionResolver([
            'auth' => $this->auth(),
            'characters' => $this->characters(),
            'world' => $this->world()
        ]);
    }

    /**
     * Get a characters database connection
     *
     * @return \Illuminate\Database\Connection
     */
    public function characters()
    {
        return DB::connection(
            config('services.skyfire.db_characters')
        );
    }

    /**
     * Get a auth database connection
     *
     * @return \Illuminate\Database\Connection
     */
    public function auth()
    {
        return DB::connection(
            config('services.skyfire.db_auth')
        );
    }

    /**
     * Get a world database connection
     *
     * @return \Illuminate\Database\Connection
     */
    public function world()
    {
        return DB::connection(
            config('services.skyfire.db_world')
        );
    }
}
