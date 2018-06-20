<?php

namespace App\Http\Controllers;

use App\Emulator;
use App\Http\Requests\Purchase\PurchaseApplyRequest;
use App\Jobs\ApplyCharacterServices;
use App\Jobs\PurchaseApply;
use App\Jobs\SendCharacterItems;
use App\Purchase;
use Illuminate\Support\Facades\Route;

class PurchaseApplyController extends Controller
{
    public function __construct()
    {
        Route::bind('purchase', function ($id) {
            return Purchase::query()->with(['items'])->findOrFail($id);
        });
    }

    public function store(Purchase $purchase, PurchaseApplyRequest $request)
    {
        $this->authorize('apply', $purchase);

        $characterId = $request->input('character_id');
        $emulator = $request->input('emulator');

        PurchaseApply::withChain([
            new ApplyCharacterServices($purchase, $characterId, $emulator),
            new SendCharacterItems($purchase, $characterId, $emulator)
        ])->dispatch($purchase);
    }
}
