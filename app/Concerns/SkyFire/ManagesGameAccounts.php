<?php

namespace App\Concerns\SkyFire;

use App\User;
use Illuminate\Support\Facades\DB;

trait ManagesGameAccounts
{
    use EncryptsPassword;

    /**
     * Tell the underlying game server to create an account for given user.
     *
     * @param  \App\User $user
     * @param  string    $password
     * @return int
     */
    public function createAccount($user, $password)
    {
        return $this->auth()->table('account')->insertGetId([
            'username' => $user->account_name,
            'email' => $user->email,
            'sha_pass_hash' => $this->makePassword($user, $password)
        ]);
    }

    /**
     * Delete the skyfire account of given user.
     *
     * @param User $user
     * @return bool
     */
    public function deleteAccount($user)
    {
        return $this->auth()->table('account')->where('id', $this->findAccount($user)->id)->delete() > 0;
    }

    /**
     * Find a game account
     *
     * @param User|string $user
     * @return \App\GameAccount
     */
    public function findAccount($user)
    {
        $user = ($user instanceof User) ? $user : User::where('account_name', $user)->firstOrFail();

        if ($user->gameAccounts()->where('emulator', 'SkyFire')->exists()) {
            return $user->gameAccounts()->where('emulator', 'SkyFire')->first();
        }

        $skyFireAccount = $this->auth()->table('account')->where('username', $user->account_name)->firstOrFail();
        return $user->gameAccounts()->create([
            'emulator' => 'SkyFire',
            'user_id' => $user->id,
            'account_id' => $skyFireAccount->id
        ]);
    }

    /**
     * Find a character record by their name & account id
     *
     * @param string|integer $name
     * @param integer $accountId
     * @return object
     */
    public function findCharacter($name, $accountId)
    {
        if (is_numeric($name)) {
            return (object)['guid' => $name];
        }

        return $this->characters()
            ->table('characters')
            ->where('account', $accountId)
            ->where('name', $name)
            ->firstOrfail();
    }
}
