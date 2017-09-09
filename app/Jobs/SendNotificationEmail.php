<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendNotificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @param Mailer $mailer
     */
    public function handle(Mailer $mailer)
    {
        $mailer->send('email.welcome', ['data'=>'data'], function ($message) {

            $message->from('mohammad.ghazavi@gmail.com', 'Muhammad Ghazavi');

            $message->to('mohammad.ghazavi@gmail.com');
        });
    }
}
