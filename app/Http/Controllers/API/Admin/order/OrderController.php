<?php

namespace App\Http\Controllers\API\Admin\order;

use App\Events\OrderMailEvent;
use App\Events\UserMailEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\NotificationManage;
use App\Models\Order;
use App\Repositories\NotificationRepository;
use App\Repositories\OrderRepository;
use App\Services\NotificationServices;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $paymentStatus = \request('payment_status') ?? config('enums.payment_status.paid');
        $orders = (new OrderRepository())->getSortedByRequest($request,$paymentStatus);
        return $this->json('Orders list', [
            'orders' => OrderResource::collection($orders)
        ]);
    }

    public function orderDetails($id)
    {
        $order = (new OrderRepository())->findById($id);

        return $this->json('order details', [
            'order' => (new OrderResource($order))
        ]);
    }

    public function statusUpdate(Order $order)
    {
        $status = config('enums.order_status.' . request('status'));

        if (!in_array($status, config('enums.order_status'))) {
            return $this->json('Invalid status',[],Response::HTTP_BAD_REQUEST);
        }
        $order = (new OrderRepository())->StatusUpdateByRequest($order, $status);

        $orderStatus = NotificationManage::where('name', $status)->first();

        if($order->customer->devices->count() && $orderStatus->is_active){
            $message = $orderStatus->message;
            $keys = $order->customer->devices->pluck('key')->toArray();
            (new NotificationServices($message, $keys, 'Order Status Update'));
            (new NotificationRepository())->storeByRequest($order->customer->id, $message, 'Order status update');
        }

        if ($order->customer->user->email) {
            OrderMailEvent::dispatch($order);
        }

        return $this->json('Order status is updated successfully',[
            'order' => (new OrderResource($order))
        ]);

    }
}
