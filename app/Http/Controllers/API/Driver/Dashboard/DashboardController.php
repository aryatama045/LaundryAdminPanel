<?php

namespace App\Http\Controllers\API\Driver\Dashboard;

use App\Events\OrderMailEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\NotificationManage;
use App\Models\Order;
use App\Repositories\DriverRepository;
use App\Repositories\OrderRepository;
use App\Services\NotificationServices;
use Illuminate\Http\Response;

class DashboardController extends Controller
{
    public function today()
    {
        $orders = (new DriverRepository())->getTodaysOrder();

        return $this->json('Todays orders list', [
            'orders' => OrderResource::collection($orders)
        ]);
    }

    public function todayPending()
    {
        $orders = (new DriverRepository())->getTodaysTotalPending();

        return $this->json('Today pending orders', [
            'total' => count($orders),
            'orders' => OrderResource::collection($orders)
        ]);
    }

    public function todayOrders()
    {
        $status = \request()->status;
        $orders = (new DriverRepository())->getTodaysOrderByRequest($status);

        return $this->json('Today orders', [
            'total' => count($orders),
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
            return $this->json('Invalid status', [], Response::HTTP_BAD_REQUEST);
        }
        $order = (new OrderRepository())->StatusUpdateByRequest($order, $status);

        $notificationStatus = NotificationManage::where('name', $status)->first();

        if ($order->customer->devices->count() && $notificationStatus?->is_active) {
            $message = $notificationStatus->message;
            $keys = $order->customer->devices->pluck('key')->toArray();
            $title = "Order Status Updated";
            (new NotificationServices($message, $keys, $title));
        }

        if ($order->customer->user->email) {
            OrderMailEvent::dispatch($order);
        }

        return $this->json('Order status is updated successfully', [
            'order' => (new OrderResource($order))
        ]);
    }

    public function thisWeek()
    {
        $orders = (new DriverRepository())->getThisWeekDelivery();
        return $this->json('Orders list', [
            'total' => count($orders),
            'orders' => OrderResource::collection($orders)
        ]);
    }

    public function lastWeek()
    {
        $orders = (new DriverRepository())->getLastWeek();
        return $this->json('Orders list', [
            'total' => count($orders),
            'orders' => OrderResource::collection($orders)
        ]);
    }

    public function totalOrder()
    {
        $orders = (new DriverRepository())->getTotalOrder();
        return $this->json('Orders list', [
            'total' => count($orders),
            'orders' => OrderResource::collection($orders)
        ]);
    }

    public function acceptOrder(Order $order)
    {
        $auth = auth()->user()->driver;
        if (\request()->isAccept == 1) {
            $order = $order->drivers()->updateExistingPivot($auth->id,['is_accept' => 1]);
            return $this->json('Order accepted successfully');
        }

        $order->drivers()->detach($auth->id);
        return $this->json('Order deleted');

    }

    public function history()
    {
        $orders =  auth()->user()->driver->orderHistories;
        return $this->json('Order histories list', [
            'total' => count($orders),
            'orders' => OrderResource::collection($orders)
        ]);
    }
}
