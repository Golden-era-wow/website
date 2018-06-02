<?php

namespace App\Providers;

use CollabCorp\LaravelFeatureToggle\Feature;
use Illuminate\Support\ServiceProvider;

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
    }
}
