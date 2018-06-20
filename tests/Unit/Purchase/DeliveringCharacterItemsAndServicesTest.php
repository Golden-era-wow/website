<?php

namespace Tests\Unit\Purchase;

use App\Jobs\PurchaseApplyJob;
use App\Jobs\SendCharacterItems;
use App\Product;
use App\Purchase;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DeliveringCharacterItemsAndServicesTest extends TestCase
{
    use RefreshDatabase;

    protected $connectionsToTransact = ['mysql', 'skyfire_auth', 'skyfire_characters'];

    /** @test */
    public function boughtItemsGetsDeliveredByMail()
    {
        $this->actingAs($user = factory(User::class)->states(['with cart', 'with skyfire account'])->create());
        $item = factory(Product::class)->states('gear')->create(['reference' => 1]);
        $user->cart->add($item);

        $purchase = factory(Purchase::class)->create(['user_id' => $user->id, 'cart_id' => $user->cart->id]);

        DB::connection('skyfire_characters')->table('characters')->insert([
            'account' => $user->gameAccounts->first()->account_id,
            'guid' => $guid = DB::connection('skyfire_characters')->table('characters')->max('guid') + 1,
            'name' => 'testing',
            'taximask' => 1
        ]);

        (new SendCharacterItems($purchase, $guid, 'SkyFire'))->handle();

        $this->assertDatabaseHas('mail', [
            'receiver' => $guid,
            'stationery' => 61, // GM,
            'has_items' => true,
            'checked' => false
        ], 'skyfire_characters');

        $this->assertDatabaseHas('mail_items', [
            'item_guid' => $item->reference,
            'receiver' => $guid
        ], 'skyfire_characters');

        DB::connection('skyfire_characters')->table('characters')->where('guid', $guid)->delete();
        DB::connection('skyfire_characters')->table('mail_items')->where('receiver', $guid)->delete();
        DB::connection('skyfire_characters')->table('mail')->where('receiver', $guid)->delete();
    }
}
