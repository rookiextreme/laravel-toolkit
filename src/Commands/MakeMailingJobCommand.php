<?php
namespace Rookiextreme\LaravelToolkit\Commands;

use Illuminate\Console\Command;

class MakeMailingJobCommand extends Command
{
    protected $signature = 'toolkit:make-mail-job {filename?}';

    public function handle()
    {
        $filename = $this->argument('filename');

        if(!$filename)
        {
            $filename = $this->ask('Please enter a name for the mail job');
        }

        if(!$filename)
        {
            $filename = 'MailingJob_'.rand(1000, 9000);
        }

        $jobPath = app_path('Jobs');

        if(!is_dir($jobPath))
        {
            mkdir($jobPath, 755, true);
        }

        $fullFilePath = $jobPath.'/'.$filename.'.php';

        $template = file_get_contents(__DIR__.'/../'.'Templates/MailingJob.php');
        $template = str_replace('MailingJob', $filename, $template);

        file_put_contents($fullFilePath, $template);
    }
}