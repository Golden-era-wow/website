<?php

namespace Tests\Feature\Purchase;

use App\CharacterItem;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchasingCartsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function cannotPurchaseAnEmptyCart()
    {
        $this->actingAs($user = factory(User::class)->states('with cart')->create());

        $this->json('POST', "/carts/{$user->cart->id}/purchase", [])->assertStatus(404);
    }

    /** @test */
    public function cannotSubtractBalanceBelowZero()
    {
        $this->actingAs($user = factory(User::class)->states('with cart')->create(['balance' => 0]));
        $user->cart->add(factory(CharacterItem::class)->create(['cost' => 100]));

        $this->json('POST', "/carts/{$user->cart->id}/purchase", [])->assertStatus(403);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'balance' => 0
        ]);
    }

    /** @test */
    public function itSubtractsTheTotalCostFromTheUsersBalance()
    {
        $this->actingAs($user = factory(User::class)->states('with cart')->create(['balance' => 100]));
        $user->cart->add(factory(CharacterItem::class)->create(['cost' => 100]));

        $this->json('POST', "/carts/{$user->cart->id}/purchase", [])->assertSuccessful();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'balance' => 0
        ]);
    }

    /** @test */
    public function itCreatesAPaymentReference()
    {
        $this->actingAs($user = factory(User::class)->states('with cart')->create(['balance' => 100]));
        $user->cart->add(factory(CharacterItem::class)->create(['cost' => 100]));

        $this->json('POST', "/carts/{$user->cart->id}/purchase", [])->assertSuccessful();

        $this->assertDatabaseHas('payments', [
            'user_id' => $user->id,
            'amount' => 100
        ]);
    }

}
