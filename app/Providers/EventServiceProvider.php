<?php

namespace App\Providers;

use App\Events\OrderMailEvent;
use App\Events\UserMailEvent;
use App\Events\ForgotPasswordEvent;

use App\Listeners\OrderMailNotification;
use App\Listeners\UserMailNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserMailEvent::class => [
            UserMailNotification::class
        ],
        ForgotPasswordEvent::class => [
            ForgotPasswordNotification::class
        ],

        OrderMailEvent::class => [
            OrderMailNotification::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
