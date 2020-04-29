<?php

namespace Toyza55k\Backend;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;
use Laravel\Ui\UiCommand;
use Toyza55k\Backend\Backend;
use Toyza55k\Backend\Commands\BackendInitCommand;
use Toyza55k\Backend\Commands\BackendMakeControllerCommand;
use Toyza55k\Backend\Commands\BackendMakeExportCommand;
use Toyza55k\Backend\Commands\BackendMakeModelCommand;
use Toyza55k\Backend\Commands\BackendMakeRequestCommand;
use Toyza55k\Backend\Commands\BackendMakeViewModelCommand;
use Toyza55k\Backend\Preset as BackendPreset;

class BackendServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'toyza55k');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'toyza55k');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            // $this->bootForConsole();

            UiCommand::macro('backend', function (UiCommand $command) {
                BackendPreset::install();
            });

            $this->commands([
                BackendInitCommand::class,
                BackendMakeModelCommand::class,
                BackendMakeControllerCommand::class,
                BackendMakeRequestCommand::class,
                BackendMakeViewModelCommand::class,
                BackendMakeExportCommand::class,
            ]);

            // Artisan::command('backend:init', function () {
            //     $this->info('test');
            // });
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        // $this->mergeConfigFrom(__DIR__.'/../config/backend.php', 'backend');

        // // Register the service the package provides.
        // $this->app->singleton('backend', function ($app) {
        //     return new Backend;
        // });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['backend'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        // $this->publishes([
        //     __DIR__.'/../config/backend.php' => config_path('backend.php'),
        // ], 'backend.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/toyza55k'),
        ], 'backend.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/toyza55k'),
        ], 'backend.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/toyza55k'),
        ], 'backend.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
