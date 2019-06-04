<?php

namespace TeamZac\BluePay;

use Illuminate\Support\ServiceProvider;

class BluePayServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'bluepay-php');

        // if ($this->app->runningInConsole()) {
        //     $this->publishes([
        //         __DIR__.'/../config/config.php' => config_path('bluepay.php'),
        //     ], 'config');

        //     // Publishing the translation files.
        //     /*$this->publishes([
        //         __DIR__.'/../resources/lang' => resource_path('lang/vendor/bluepay-php'),
        //     ], 'lang');*/

        //     // Registering package commands.
        //     // $this->commands([]);
        // }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'bluepay');

        // Register the main class to use with the facade
        $this->app->singleton('bluepay', function ($app) {
            return new Client(
                $app['config']['bluepay']['account_id'],
                $app['config']['bluepay']['secret'],
                $app['config']['bluepay']['mode'],
                $app['config']['bluepay']['debug']
            );
        });
    }
}
