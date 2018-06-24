<?php

namespace App\Http\Controllers;

use App\Cart;
use App\CartItem;
use App\Http\Requests\CartItem\StoreCartItemRequest;
use App\Product;

class CartItemController extends Controller
{
    public function store(Cart $cart, StoreCartItemRequest $request)
    {
        $this->authorize('create', new CartItem);

        $cart->add(
            Product::find($request->input('product_ids'))
        );

        return $cart->load('items');
    }

    public function destroy(CartItem $item)
    {
        $this->authorize('delete', $item);

        $item->cart->removeAll($item->product);
        //$item->delete();
    }
}
