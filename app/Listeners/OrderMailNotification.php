<?php

namespace App\Listeners;

use App\Events\OrderMailEvent;
use App\Mail\orderMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class OrderMailNotification
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
    public function handle(OrderMailEvent $event)
    {
        if (env('MAIL_USERNAME') && env('MAIL_PASSWORD')) {
            Mail::to($event->order->customer->user->email)->send(new orderMail($event->order));
        }
    }
}
