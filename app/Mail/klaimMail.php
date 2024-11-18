<?php

namespace App\Mail;

use App\Models\DeliveryCost;
use App\Models\WebSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class klaimMail extends Mailable
{
    use Queueable, SerializesModels;
    public $klaim;
    public $delivery_charge;
    public $setting;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($klaim)
    {
        $this->klaim = $klaim;

        $this->setting = WebSetting::first();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->setting->name ?? config('app.name'))
                    ->view('mail.mailKlaim',['klaim' => $this->klaim,'setting' => $this->setting]);
    }
}
