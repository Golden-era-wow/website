<?php

namespace App\Providers;

use App\Cart;
use App\CartItem;
use App\Policies\CartItemPolicy;
use App\Policies\CartPolicy;
use App\Policies\PurchasePolicy;
use App\Purchase;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

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

        Passport::routes();

        Passport::tokensCan([
            'search-armory' => 'Search armory',
            'list-communities' => ' List communities',
            'create-community-topic' => 'Create a topic in a community board',
            'reply-community-topic' => 'Reply to a topic within a community board'
        ]);
    }
}
