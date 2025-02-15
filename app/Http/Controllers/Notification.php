<?php

namespace App\Http\Controllers;

use App\Jobs\SendNotificationJob;
use Illuminate\Http\Request;

class Notification extends Controller
{
    //

    public function sendNotification()
    {
        dispatch(new SendNotificationJob("Hi, You are notified using queue"));
    }
}
