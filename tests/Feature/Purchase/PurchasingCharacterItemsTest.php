<?php

namespace Tests\Feature\Purchase;

use App\CharacterItem;
use App\Jobs\PurchaseCartJob;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchasingCharacterItemsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function userCanPurchaseIngameItems()
    {
        $this->actingAs($user = factory(User::class)->create(['balance' => 200]));
        $items = factory(CharacterItem::class)->times(2)->create(['cost' => 100]);

        $cartId = $this->json('POST', "/carts", [])->assertSuccessful()->json()['id'];

        $this->json('POST', "/carts/{$cartId}/items", [
            'type' => 'App\CharacterItem',
            'ids' => $items->map->id,
        ])->assertSuccessful();

        $this->json('POST', "/carts/{$cartId}/purchase", [])->assertSuccessful();

        $this->assertDatabaseHas('purchases', [
            'cart_id' => $cartId,
            'created_at' => now(),
            'total_cost' => 200
        ]);
    }

    /** @test */
    public function cannotPurchaseIngameItemWithInsufficientBalance()
    {
        $this->actingAs($user = factory(User::class)->states('with cart')->create(['balance' => 0]));
        $item = factory(CharacterItem::class)->create(['cost' => 1]);

        $user->cart->add($item);

        $this->json('POST', "/carts/{$user->cart->id}/purchase", [])->assertStatus(403);

        $this->assertDatabaseMissing('purchases', [
            'cart_id' => $user->cart->id
        ]);
    }

    /** @test */
    public function cannotAddInvalidIngameItemsToCart()
    {
        $this->actingAs($user = factory(User::class)->states('with cart')->create());

        $this->json('POST', "/carts/{$user->cart->id}/items", [
            'type' => 'App\CharacterItem',
            'ids' => [1],
        ])->assertJsonValidationErrors('ids.0');
    }
}
