<?php

namespace App\Policies;

use App\Cart;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CartPolicy
{
    use HandlesAuthorization, BypassedByAdmins;

    /**
     * Determine whether the user can purchase the cart.
     *
     * @param  \App\User $user
     * @param  \App\Cart $cart
     * @return mixed
     */
    public function purchase(User $user, Cart $cart)
    {
        return $user->is($cart->user)
            && $user->balance >= $cart->items()->sum('cost');
    }

    /**
     * Determine whether the user can view the cart.
     *
     * @param  \App\User $user
     * @param  \App\Cart $cart
     * @return mixed
     */
    public function view(User $user, Cart $cart)
    {
        return $user->is($cart->user);
    }

    /**
     * Determine whether the user can create carts.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->exists;
    }

    /**
     * Determine whether the user can update the cart.
     *
     * @param  \App\User $user
     * @param  \App\Cart $cart
     * @return mixed
     */
    public function update(User $user, Cart $cart)
    {
        return $user->is($cart->user);
    }

    /**
     * Determine whether the user can delete the cart.
     *
     * @param  \App\User $user
     * @param  \App\Cart $cart
     * @return mixed
     */
    public function delete(User $user, Cart $cart)
    {
        return $user->is($cart->user);
    }
}
