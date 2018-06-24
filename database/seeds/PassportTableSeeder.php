<?php

use Illuminate\Database\Seeder;
use Laravel\Passport\ClientRepository;
use Illuminate\Support\Facades\Artisan;

class PassportTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(ClientRepository $clients)
    {
        // Artisan::call('passport:keys');
        // Artisan::call('passport:install');
        // Artisan::call('passport:client', ['--personal' => true]);
        $this->createAuthCodeClient($clients);
        $this->createPersonalAccessClient($clients);
    }

    protected function createAuthCodeClient($clients)
    {
        $userId = 1;
        $name = 'default';
        $redirect = config('app.url').'/auth/callback';

        $clients->create(
            $userId, $name, $redirect
        );
    }

    protected function createPersonalAccessClient($clients)
    {
        $name = config('app.name').' Personal Access Client';

        $clients->createPersonalAccessClient(
            null, $name, config('app.url')
        );
    }
}
