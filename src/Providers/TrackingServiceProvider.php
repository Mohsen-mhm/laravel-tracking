<?php

namespace MohsenMhm\LaravelTracking\Providers;

use Illuminate\Support\ServiceProvider;

class TrackingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Merge configuration
        $this->mergeConfigFrom(__DIR__ . '/../../config/tracking.php', 'tracking');
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'request-tracker');
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');

        // Publish config
        $this->publishes([
            __DIR__ . '/../../config/tracking.php' => config_path('tracking.php'),
        ], 'tracker-configs');

        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views/vendor/request-tracker'),
        ], 'tracker-views');

        $this->publishes([
            __DIR__.'/../../database/migrations/' => database_path('migrations'),
        ], 'tracker-migrations');
    }
}