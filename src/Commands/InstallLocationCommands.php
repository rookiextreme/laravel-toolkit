<?php
namespace Rookiextreme\LaravelToolkit\Commands;

use Illuminate\Console\Command;

class InstallLocationCommands extends Command
{
    protected $signature = 'toolkit:install-location';
    protected $description = 'Install country and state models,migrations and seeders';

    public function handle()
    {
        $this->info('Installing migrations, seeders, and models into application');
        $this->call('vendor:publish', [
            '--tag' => 'toolkit-location-migrations'
        ]);

        $this->call('vendor:publish', [
            '--tag' => 'toolkit-location-models'
        ]);

        $this->call('vendor:publish', [
            '--tag' => 'toolkit-location-seeders'
        ]);

        return self::SUCCESS;
    }
}