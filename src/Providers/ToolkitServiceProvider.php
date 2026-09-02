<?php
namespace Rookiextreme\LaravelToolkit\Providers;

use Illuminate\Support\ServiceProvider;
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
            ]);
        }
    }
}