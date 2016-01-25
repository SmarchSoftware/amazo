<?php

namespace Smarch\Amazo;

use Illuminate\Support\ServiceProvider;

class AmazoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // load the views
        $this->loadViewsFrom(__DIR__.'/Views', 'amazo');

        // Publishes package files

        // views
        $this->publishes([
            __DIR__.'/Views' => base_path('resources/views/smarch/amazo')
        ], 'views');

        // migrations
        $this->publishes([
            __DIR__.'/migrations' => $this->app->databasePath().'/migrations'
        ], 'migrations');

        // config
        $this->publishes([
            __DIR__.'/Config/amazo.php' => config_path('amazo.php')
        ], 'config');

        // Merge config files
        $this->mergeConfigFrom(__DIR__.'/Config/amazo.php','amazo');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // load our routes
        if (! $this->app->routesAreCached()) {
            require __DIR__.'/routes.php';
        }

        // Register it
        $this->app->bind('amazo', function() {
             return new \Smarch\Amazo\Amazo;
        });
    }
}
