<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class)->create(['email' => 'admin@example.com', 'is_admin' => true]);

        Artisan::call('passport:keys');
    }
}
