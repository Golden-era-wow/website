<?php

namespace App\Providers;

use App\Contracts\EmulatorContract;
use App\Http\Resources\GuildResource;
use App\Services\EmulatorManager;
use CollabCorp\LaravelFeatureToggle\Feature;
use Illuminate\Support\ServiceProvider;
use Laravel\Horizon\Horizon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        GuildResource::withoutWrapping();
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

        $this->app->bind(EmulatorContract::class, function ($app) {
            return $app[EmulatorManager::class]->driver();
        });

        Feature::bind('local', function () {
            return app()->environment('local');
        });

        Horizon::auth(function ($request) {
            return optional($request->user())->is_admin;
        });
    }
}
