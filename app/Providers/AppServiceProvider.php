<?php

namespace App\Providers;

use Laravel\Horizon\Horizon;
use Illuminate\Support\ServiceProvider;
use CollabCorp\LaravelFeatureToggle\Feature;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Feature::bind('local', function () {
            return app()->environment('local');
        });

        Horizon::auth(function ($request) {
            return optional($request->user())->is_admin;
        });
    }
}
