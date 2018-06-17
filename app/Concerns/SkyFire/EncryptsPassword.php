<?php

namespace App\Concerns\SkyFire;

use App\User;

trait EncryptsPassword
{
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
}
