<?php

namespace App\Http\Controllers;

use App\Cart;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
	public function show($id)
	{
		return view('shopping-cart.index')->with(
			'cart',
			Cart::query()->with(['products'])->findOrFail($id)
		);
	}
}
