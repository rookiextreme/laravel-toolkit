<?php
namespace Rookiextreme\LaravelToolkit\Providers;

use Illuminate\Support\ServiceProvider;
use Rookiextreme\LaravelToolkit\Commands\InstallLocationCommands;
use Rookiextreme\LaravelToolkit\Commands\MakeMailingJobCommand;

class ToolkitServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('rookiextreme-laravel-toolkit', function ($app) {

        });
    }

    public function boot(): void
    {
        if($this->app->runningInConsole()){
            $this->commands([
                MakeMailingJobCommand::class,
                InstallLocationCommands::class,
            ]);
            $this->publishesMigrations([
                __DIR__.'/../../database/location/migrations' => database_path('migrations'),
            ], 'toolkit-location-migrations');
            $this->publishes([
                __DIR__.'/../../database/location/seeders' => database_path('seeders'),
            ], 'toolkit-location-seeders');
            $this->publishes([
                __DIR__.'/../../database/location/models' => app_path('Models'),
            ], 'toolkit-location-models');
        }
    }
}