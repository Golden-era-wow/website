<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Interactions\Purchase\PurchaseCart;
use App\Jobs\CartPurchaseJob;

class CartPurchaseController extends Controller
{
    public function store($id)
    {
        /** @var Cart $cart */
        $cart = Cart::available()->has('items')->findOrFail($id);

        $this->authorize('purchase', $cart);

        dispatch(new CartPurchaseJob($cart));
    }
}
