<?php

namespace App\Http\Controllers;

use App\Http\Requests\Purchase\PurchaseApplyRequest;
use App\Jobs\PurchaseApplyJob;
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

        dispatch(new PurchaseApplyJob(
            $purchase,
            $request->input('character_id'),
            $request->input('emulator')
        ));

        $purchase->applied();
    }
}
