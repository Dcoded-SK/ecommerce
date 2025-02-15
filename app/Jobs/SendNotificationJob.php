<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\SendNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    public $message;
    public function __construct($message)
    {
        //

        $this->$message = $message;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //

        $users = User::all();

        foreach ($users as $user) {
            # code...
            $user->notify(new SendNotification($this->message));
        }
    }
}
