<?php

namespace App\Policies;

use App\Purchase;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PurchasePolicy
{
    use HandlesAuthorization, BypassedByAdmins;

    /**
     * Determine whether the user can apply the purchase.
     *
     * @param  \App\User $user
     * @param  \App\Purchase $purchase
     * @return mixed
     */
    public function apply(User $user, Purchase $purchase)
    {
        if ($purchase->applied) {
            return false;
        }

        return $purchase->user->is($user);
    }

    /**
     * Determine whether the user can view the purchase.
     *
     * @param  \App\User $user
     * @param  \App\Purchase $purchase
     * @return mixed
     */
    public function view(User $user, Purchase $purchase)
    {
        return $purchase->user->is($user);
    }

    /**
     * Determine whether the user can create purchases.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->exists;
    }

    /**
     * Determine whether the user can update the purchase.
     *
     * @param  \App\User $user
     * @param  \App\Purchase $purchase
     * @return mixed
     */
    public function update(User $user, Purchase $purchase)
    {
        return $purchase->user->is($user);
    }

    /**
     * Determine whether the user can delete the purchase.
     *
     * @param  \App\User $user
     * @param  \App\Purchase $purchase
     * @return mixed
     */
    public function delete(User $user, Purchase $purchase)
    {
        return $purchase->user->is($user);
    }
}
