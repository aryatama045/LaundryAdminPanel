<?php

namespace App\Mail;

use App\Models\DeliveryCost;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class forgotPassword extends Mailable
{
    use Queueable, SerializesModels;
    public $setting;
    public $user;
    public $otp;
    /**
     * Create a new message instance.
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
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->subject('Forgot-Password')
                    ->view('mail.forgotPassword',['setting' => $this->setting, 'user' => $this->user,'otp'=>$this->otp]);
    }
}
