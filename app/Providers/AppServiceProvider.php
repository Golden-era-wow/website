<?php

namespace App\Providers;

use Laravel\Horizon\Horizon;
use App\Services\EmulatorManager;
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
        $this->app->singleton(EmulatorManager::class, function ($app) {
            return new EmulatorManager($app);
        });

        Feature::bind('local', function () {
            return app()->environment('local');
        });

        Horizon::auth(function ($request) {
            return optional($request->user())->is_admin;
        });
    }
}
