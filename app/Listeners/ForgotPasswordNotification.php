<?php

namespace App\Listeners;

use App\Events\ForgotPasswordEvent;
use App\Mail\forgotPassword;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordNotification
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
     * @param  \App\Events\ForgotPasswordEvent  $event
     * @return void
     */
    public function handle(ForgotPasswordEvent $event)
    {
        // dd($event);
        // if (env('MAIL_USERNAME') && env('MAIL_PASSWORD')) {
            Mail::to($event->user->email)->send(new forgotPassword($event->user, $event->otp));
        // }
    }
}
