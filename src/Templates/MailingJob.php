<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class MailingJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(readonly string $type, readonly array $to = [], readonly array $from = ['email' => 'noreply@mail.com'], readonly string $subject = '', readonly string $blade = '', readonly array $data = [], readonly string $attachment = '')
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try{
            if($this->blade){
                $subject = $this->subject;
                $to = $this->to;
                $from = $this->from;
                $type = $this->type;
                $attachment = $this->attachment;
                $data = $this->data;

                Mail::send($this->blade, $this->data, function($message) use ($to, $from, $subject, $attachment, $type, $data) {
                    $message->to($to)
                        ->subject($subject);
                    $message->from($from['email']);
                    if($attachment){
                        $message->attach($attachment);
                    }

                    //Add your conditions here for specific things needed to do
                    //if($type == 'some-string'){}
                });
            }
        }catch (\Exception $e){
            echo '<pre>';
            print_r($e->getMessage());
            echo '</pre>';
            die();
        }
    }
}
