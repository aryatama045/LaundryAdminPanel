<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\WebSetting;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripePaymentController extends Controller
{
    public function index()
    {
        $orderId = request()->orderId;
        $order = (new OrderRepository())->find($orderId);
        if (!$order) {
            return redirect()->to(config('app.frontend_url') . '/my-order');
        }

        $amount = $order->total_amount;

        $weSetting = WebSetting::first();
        Stripe::setApiKey(config('app.stripe_secret'));


        $intent = PaymentIntent::create([
            'amount' => ($amount) * 100,
            'currency' => 'GBP',
            'description' => $weSetting?->name . ' order payment received from Web.',
            'metadata' => ['integration_check' => 'accept_a_payment', 'order_id' => $order]
        ]);


        return view('web.stripe-payment', [
            'client_secret' => $intent->client_secret,
            'amount' => $amount,
            'order' => $order
        ]);
    }

    public function charge(Request $request)
    {
        $orderId = $request->orderId;
        $order = (new OrderRepository())->find($orderId);
        $order->update([
            'payment_status' => config('enums.payment_status.paid'),
        ]);
        return redirect()->to(config('app.frontend_url') . '/order-finished?code='.$order->order_code);
    }
}
