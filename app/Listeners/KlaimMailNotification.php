<?php

namespace App\Listeners;

use App\Events\KlaimMailEvent;
use App\Mail\klaimMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class klaimMailNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(KlaimMailEvent $event)
    {
        if (env('MAIL_USERNAME') && env('MAIL_PASSWORD')) {
            Mail::to($event->klaim->customer->user->email)->send(new klaimMail($event->klaim));
        }
    }
}
