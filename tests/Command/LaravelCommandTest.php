<?php
namespace Tests\Command;

use Orchestra\Testbench\TestCase;
use Rookiextreme\LaravelToolkit\Providers\ToolkitServiceProvider;

class LaravelCommandTest extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            ToolkitServiceProvider::class,
        ];
    }

    public function test_make_mailing_job_command_argument()
    {
        $this->artisan('toolkit:make-mail-job UserMailingJob')->assertExitCode(0);
        $this->assertFileExists(app_path('Jobs/UserMailingJob.php'));
    }

    public function test_make_mailing_job_command_no_argument()
    {
        $this->artisan('toolkit:make-mail-job')->expectsQuestion('Please enter a name for the mail job', 'UserMailingJob')->assertExitCode(0);
        $this->assertFileExists(app_path('Jobs/UserMailingJob.php'));
    }
}