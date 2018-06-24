<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class CartProductController extends Controller
{
    public function store(Cart $cart, Product $product)
    {
        $this->authorize('create', new CartItem);

        $cart->add($product);
    }

    public function destroy(Cart $cart, Product $product)
    {
    	$cart->remove($product);
    }
}