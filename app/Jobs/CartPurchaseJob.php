<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CartPurchaseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $cart;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($cart)
    {
        $this->cart = $cart;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $totalCost = $this->cart->items->sum('cost') ?? 0;

        $this->cart->user->balance -= $totalCost;
        $this->cart->user->saveOrFail();

        $purchase = $this->cart->user->purchases()->create([
            'cart_id' => $this->cart->id,
            'user_id' => $this->cart->user->id,
            'total_cost' => $totalCost,
        ]);

        $payment = $this->cart->user->payments()->create([
            'user_id' => $this->cart->user->id,
            'purchase_id' => $purchase->id,
            'amount' => $totalCost
        ]);

        $this->cart->purchase();

        return $purchase;
    }
}
