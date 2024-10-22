<?php

namespace App\Http\Controllers\API\Payment;

use App\Events\OrderMailEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\NotificationManage;
use App\Repositories\OrderRepository;
use App\Repositories\PaymentRepository;

class PaymentController extends Controller
{
    public function store(PaymentRequest $request)
    {
        $order = (new OrderRepository())->findById($request->order_id);

        (new PaymentRepository())->storeByRequestFromApi($request);

        if($request->status == 'succeeded'){
            $order->update([
                'payment_status' => config('enums.payment_status.paid'),
            ]);

            OrderMailEvent::dispatch($order);

        }

        return $this->json('Order payment is received successfully',[
            'payment' => (new PaymentResource($request))
        ]);
    }
}
