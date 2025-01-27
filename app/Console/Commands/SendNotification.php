<?php

namespace App\Console\Commands;

use App\Mail\SendGmailNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command send the notification throw the given gmail address';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $emails = ['skohar098@rku.ac.in', 'shivsagarkohar32@gmail.com'];

        foreach ($emails as $email)
            Mail::to($email)->send(new SendGmailNotification($email)); {
        }


        $this->info("Notification will be send to the given gmail address");
    }
}
