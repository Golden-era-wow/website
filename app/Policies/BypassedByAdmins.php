<?php

namespace App\Policies;

trait BypassedByAdmins
{
    public function before($user, $ability)
    {
        if ($user->is_admin) {
            return true;
        }
    }
}
