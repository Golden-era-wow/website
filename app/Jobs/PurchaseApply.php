<?php

namespace App\Jobs;

use App\CartItem;
use App\CharacterItem;
use App\Contracts\EmulatorContract;
use App\Emulator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PurchaseApply implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The purchase we're applying
     *
     * @var \App\Purchase
     */
    public $purchase;

    /**
     * Create a new job instance.
     *     
     * @param \App\Purchase $purchase  
     */
    public function __construct($purchase)
    {
        $this->purchase = $purchase;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->purchase->applied();
    }
}
