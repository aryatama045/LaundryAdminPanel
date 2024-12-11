<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $setting;
    public $user;
    public $otp;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($setting, $user, $otp)
    {
        $this->setting = $setting;
        $this->user = $user;
        $this->otp = $otp;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
