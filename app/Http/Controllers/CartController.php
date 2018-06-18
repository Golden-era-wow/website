<?php

namespace App\Http\Controllers;

use App\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(Request $request)
    {
        $this->authorize('create', new Cart);

        return $request
            ->user()
            ->cart()
            ->create();
    }
}
