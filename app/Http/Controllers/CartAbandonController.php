<?php

namespace App\Http\Controllers;

use App\Cart;

class CartAbandonController extends Controller
{
    public function store(Cart $cart)
    {
        $this->authorize('delete', $cart);

        $cart->abandon();

        return $cart;
    }
}
