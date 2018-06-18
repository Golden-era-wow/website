<?php

namespace App\Jobs;

use App\CartItem;
use App\CharacterItem;
use App\Emulator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PurchaseApplyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The purchase we're applying
     *
     * @var \App\Purchase
     */
    public $purchase;

    /**
     * GUID of the character that's receiving the content of the purchase.
     *
     * @var integer
     */
    public $characterId;

    /**
     * Name of the target emulator
     *
     * @var string
     */
    public $emulator;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($purchase, $characterId, $emulator)
    {
        $this->purchase = $purchase;
        $this->characterId = $characterId;
        $this->emulator = $emulator;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Emulator::driver($this->emulator)->sendItems(
            $this->characterId,
            $this->characterItems()
        );
    }

    public function characterItems()
    {
        return $this
            ->purchase
            ->items
            ->where('purchasable_type', CharacterItem::class)
            ->map(function (CartItem $cartItem) {
                return $cartItem
                    ->purchasable()
                    ->select(['item_guid'])
                    ->getResults();
            });
    }
}
