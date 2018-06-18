<?php

namespace App\Http\Controllers;

use App\Cart;
use App\CartItem;
use App\Http\Requests\CartItem\StoreCartItemRequest;

class CartItemController extends Controller
{
    public function store(Cart $cart, StoreCartItemRequest $request)
    {
        $this->authorize('create', new CartItem);

        $model = $request->input('type');

        foreach (array_wrap($request->input('ids')) as $id) {
            $cart->items()->create([
                'purchasable_type' => $model,
                'purchasable_id' => $id,
                'cost' => $model::query()->find($id, ['cost'])->cost
            ]);
        }

        return $cart->load('items');
    }

    public function destroy(CartItem $item)
    {
        $this->authorize('delete', $item);

        $item->delete();
    }
}
