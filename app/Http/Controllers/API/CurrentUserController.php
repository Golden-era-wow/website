<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CurrentUserController extends Controller
{
    public function show(Request $request)
    {
    	$this->validate($request, [
    		'with' => 'array',
    		'with.*' => 'required_with:with|string|in:cart,carts,game_accounts,purchases,payments'
    	]);

    	return tap($request->user(), function ($user) use ($request) {
    		if ($request->has('with')) {
    			$user->load(
    				array_map('camel_case', $request->input('with'))
    			);
    		}
    	});
    }
}
