<?php

namespace App\Listeners;

use App\Events\DaftarMailEvent;
use App\Mail\mailSend;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class UserMailNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\DaftarMailEvent  $event
     * @return void
     */
    public function handle(DaftarMailEvent $event)
    {
        if (env('MAIL_USERNAME') && env('MAIL_PASSWORD')) {
            Mail::to($event->user->email)->send(new mailSend($event->user, $event->otp));
        }
    }
}
