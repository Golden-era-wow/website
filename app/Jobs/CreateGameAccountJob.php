<?php

namespace App\Jobs;

use App\GameAccount;
use App\Services\SkyFire;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateGameAccountJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The user we're registering an account for.
     *
     * @var \App\User
     */
    public $user;

    /**
     * The users desired password.
     *
     * @var string
     */
    public $password;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $accountId = (new SkyFire)->createAccount($this->user, $this->password);

        GameAccount::create(
            [
            'emulator' => 'SkyFire',
            'account_id' => $accountId,
            'user_id' => $this->user->id,
            ]
        );
    }
}
