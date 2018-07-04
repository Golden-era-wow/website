<?php

namespace App\Providers;

use AlgoliaSearch\Client as Algolia;
use App\Contracts\EmulatorContract;
use App\Contracts\Emulators\GathersGameStatistics;
use App\Contracts\Emulators\ManagesGameAccounts;
use App\Contracts\Emulators\ResolvesDatabaseConnections;
use App\Contracts\Emulators\SendsIngameMails;
use App\Emulators\EmulatorManager;
use App\Mail;
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

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Algolia::class, function ($app) {
            $config = $app['config'];

            return new Algolia(
                $config['services.algolia.app_id'],
                $config['services.algolia.admin_key']
            );
        });

        $this->registerEmulatorBindings();

        Feature::bind('local', function () {
            return app()->environment('local');
        });

        Horizon::auth(function ($request) {
            return optional($request->user())->is_admin;
        });
    }

    public function registerEmulatorBindings()
    {
        $this->app->singleton(EmulatorManager::class, function ($app) {
            return new EmulatorManager($app);
        });

        $this->app->bind(EmulatorContract::class, function ($app) {
            return $app[EmulatorManager::class]->driver();
        });

        $this->app->bind(SendsIngameMails::class, function ($app) {
            return Mail::makeWithEmulator($app[EmulatorContract::class]);
        });

        $this->app->bind(ResolvesDatabaseConnections::class, function ($app) {
            return $app[EmulatorContract::class]->database();
        });

        $this->app->bind(GathersGameStatistics::class, function ($app) {
            return $app[EmulatorContract::class]->statistics();
        });
    }
}
