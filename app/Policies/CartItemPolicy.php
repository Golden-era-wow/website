<?php

namespace App\Policies;

use App\CartItem;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CartItemPolicy
{
    use HandlesAuthorization, BypassedByAdmins;

    /**
     * Determine whether the user can view the cart item.
     *
     * @param  \App\User $user
     * @param  \App\CartItem $cartItem
     * @return mixed
     */
    public function view(User $user, CartItem $cartItem)
    {
        return $cartItem->cart->user->is($user);
    }

    /**
     * Determine whether the user can create cart items.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->exists;
    }

    /**
     * Determine whether the user can update the cart item.
     *
     * @param  \App\User $user
     * @param  \App\CartItem $cartItem
     * @return mixed
     */
    public function update(User $user, CartItem $cartItem)
    {
        return $cartItem->cart->user->is($user);
    }

    /**
     * Determine whether the user can delete the cart item.
     *
     * @param  \App\User $user
     * @param  \App\CartItem $cartItem
     * @return mixed
     */
    public function delete(User $user, CartItem $cartItem)
    {
        return $cartItem->cart->user->is($user);
    }
}
