<?php

namespace App\Mail;

use App\Models\DeliveryCost;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class mailSend extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $otp;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $otp)
    {
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

        return $this->subject('Laundry One Time Password (OTP)')
                    ->view('mail.sendMail',['user' => $this->user,'otp'=>$this->otp]);
    }
}
