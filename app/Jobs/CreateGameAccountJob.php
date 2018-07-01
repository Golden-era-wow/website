<?php

namespace App\Jobs;

use App\Emulator;
use App\GameAccount;
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
     * The emulators we're creating an account on
     *
     * @var array
     */
    public $emulators;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $password, array $emulators = ['SkyFire'])
    {
        $this->user = $user;
        $this->password = $password;
        $this->emulators = $emulators;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->emulators as $emulator) {
            $accountId = Emulator::driver($emulator)->createAccount($this->user, $this->password);

            GameAccount::create([
                'emulator' => $emulator,
                'account_id' => $accountId,
                'user_id' => $this->user->id
            ]);
        }
    }
}
