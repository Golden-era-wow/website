<?php

namespace App\Services;

use App\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SkyFire
{
    const MAIL_STATIONERY_NORMAL = 41;
    const MAIL_STATIONERY_GM = 61;
    const MAIL_STATIONERY_AUCTION = 62;

    /**
     * Tell the underlying game server to create an account for given user.
     *
     * @param  \App\User $user
     * @param  string    $password
     * @return int
     */
    public function createAccount($user, $password)
    {
        return DB::connection('skyfire_auth')->table('account')->insertGetId([
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
        return DB::connection('skyfire_auth')->table('account')->where('id', $this->findAccount($user)->id)->delete() > 0;
    }

    /**
     * Find a game account
     *
     * @param User|string $user
     * @return object
     */
    public function findAccount($user)
    {
        $user = ($user instanceof User) ? $user : User::where('account_name', $user)->firstOrFail();

        if ($user->gameAccounts()->where('emulator', 'SkyFire')->exists()) {
            return $user->gameAccounts()->where('emulator', 'SkyFire')->first();
        }

        return tap(DB::connection('skyfire_auth')->table('account')->where('username', $user->account_name)->firstOrFail(), function ($skyFireAccount) use ($user) {
            $user->gameAccounts()->create([
                'emulator' => 'SkyFire',
                'user_id' => $user->id,
                'account_id' => $skyFireAccount->id
            ]);
        });
    }

    /**
     * Make a password for the underlying game server
     *
     * @param User $user
     * @param string $value
     * @todo Improve password "encryption" on game server...
     *
     * @return string
     */
    public function makePassword($user, $value)
    {
        $encrypted = sha1(strtoupper($user->account_name) . ":" . strtoupper($value));

        return strtoupper($encrypted);
    }

    /**
     * Send the items to the recipient character by ingame mail(s).
     *
     * @param string  $recipient
     * @param array   $items
     * @param integer $perMail
     *
     * @return void
     */
    public function sendItems($recipient, $items, $perMail = 8)
    {
        tap(DB::connection('skyfire_characters'), function ($database) use ($recipient, $items, $perMail) {
            $receiver = $this->findAccount($recipient);

            $mail = $database->table('mail')->insertGetId([
                'id' => $database->table('mail')->max('id') +1,
                'receiver' => $receiver->id,
                'subject' => trans('ingame_mails.items.subject'),
                'body' => trans('ingame_mails.items.body'),
                'stationery' => static::MAIL_STATIONERY_GM,
                'has_items' => true,

                'expire_time' => now()->addWeeks(2)->getTimestamp(),
                'deliver_time' => now()->getTimestamp(),
            ]);

            Collection::make($items)
                ->chunk($perMail)
                ->each(function ($items) use ($mail, $receiver, $database) {
                    $database->table('mail_items')->insert([
                        'mail_id' => $mail,
                        'receiver_id' => $receiver->id,
                        'item_guid' => $items
                    ]);
                });
        });
    }
}
