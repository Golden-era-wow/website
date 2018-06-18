<?php

namespace App\Providers;

use App\Cart;
use App\CartItem;
use App\Policies\CartItemPolicy;
use App\Policies\CartPolicy;
use App\Policies\PurchasePolicy;
use App\Purchase;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Cart::class => CartPolicy::class,
        CartItem::class => CartItemPolicy::class,
        Purchase::class => PurchasePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
