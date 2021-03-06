<?php

namespace Tests\Feature\Purchase;

use App\Product;
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
        $user->cart->add(factory(Product::class)->states('gear')->create(['cost' => 100]));

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
        $user->cart->add(factory(Product::class)->states('gear')->create(['cost' => 100]));

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
        $user->cart->add(factory(Product::class)->states('gear')->create(['cost' => 100]));

        $this->json('POST', "/carts/{$user->cart->id}/purchase", [])->assertSuccessful();

        $this->assertDatabaseHas('payments', [
            'user_id' => $user->id,
            'amount' => 100
        ]);
    }

    /** @test */
    function itIncrementsProductTotalSalesOnPurchase() 
    {
        $this->actingAs($user = factory(User::class)->states('with cart')->create(['balance' => 100]));
        $user->cart->add($product = factory(Product::class)->states('gear')->create([
            'cost' => 100,
            'total_sales' => 0
        ]));

        $this->json('POST', "/carts/{$user->cart->id}/purchase", [])->assertSuccessful();

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'total_sales' => 1
        ]);
    } 

}
