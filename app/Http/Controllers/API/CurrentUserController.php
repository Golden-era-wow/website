<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\ClientRepository;

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

    public function update(Request $request)
    {
        $validated = $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'email', Rule::unique('users', 'email')->ignore($request->user()->id)]
        ]);

        return tap($request->user())->update($validated);
    }

    public function destroy(Request $request, ClientRepository $clients)
    {
        $user = $request->user();

        $user->clients()->each(function ($client) use ($clients) {
            $clients->delete($client);
        });

        $user->delete();

        return redirect('/');
    }
}
