<?php

namespace App\Mail;

use App\Models\DeliveryCost;
use App\Models\WebSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class orderMail extends Mailable
{
    use Queueable, SerializesModels;
    public $order;
    public $delivery_charge;
    public $setting;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;

        $deliveryCost = DeliveryCost::first();
        $freeDelivery = $deliveryCost ? $deliveryCost->fee_cost : 0.0;
        $delivery_charge = $deliveryCost ? $deliveryCost->cost : 0.0;
        $this->delivery_charge = $this->order->amount <= $freeDelivery ? $delivery_charge : '0.00';
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
                    ->view('mail.mail',['order' => $this->order,'delivery_charge'=>$this->delivery_charge,'setting' => $this->setting]);
    }
}
