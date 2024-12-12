<?php


namespace App\Repositories;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Models\Additional;
use App\Models\DeliveryCost;
use App\Models\DriverHistory;
use App\Models\SubProduct;
use Carbon\Carbon;

class OrderRepository extends Repository
{
    public function model()
    {
        return Order::class;
    }

    public function getByStatus($status)
    {
        return $this->query()->where('order_status', $status)
            ->where('payment_status', config('enums.payment_status.paid'))
            ->get();
    }
    public function getByTodays()
    {
        return $this->model()::whereDate('created_at', Carbon::today())->get();
    }

    public function storeByRequest(OrderRequest $request): Order
    {

        $lastOrder = $this->query()->latest('id')->first();

        $customer = auth()->user()->customer;
        $getAmount = $this->getAmount($request);

        $payment_type = $request->payment_type == 'cash_on_delivery' ? config('enums.payment_types.cash_on_delivery') : config('enums.payment_types.online_payment');

        $order = $this->create([
            'customer_id' => $customer->id,
            'order_code' => str_pad($lastOrder ? $lastOrder->id + 1 : 1, 6, "0", STR_PAD_LEFT),
            'prefix' => 'LM',
            'coupon_id' => $request->coupon_id,
            'discount' => $getAmount['discount'],
            'pick_date' => $request->pick_date,
            'delivery_date' => $request->delivery_date,
            'pick_hour' => $this->setPickOrDeliveryTime($request->pick_date, $request->pick_hour),
            'delivery_hour' => $this->setPickOrDeliveryTime($request->delivery_date, $request->delivery_hour, 'delivery'),
            'amount' => $getAmount['subTotal'],
            'total_amount' => $getAmount['total'],
            'delivery_charge' => $getAmount['deliveryCharge'],
            'payment_status' => config('enums.payment_status.pending'),
            'payment_type' => $payment_type,
            'order_status' => config('enums.payment_status.pending'),
            'address_id' => $request->address_id,
            'instruction' => $request->instruction
        ]);

        foreach ($request->products as $product) {
            $order->products()->attach($product['id'], ['quantity' => $product['quantity']]);
        }

        return $order;
    }

    public function updateByRequest($request, Order $order)
    {
        $request['coupon_id'] = $order->coupon_id;
        $getAmount = $this->getAmount($request);

        $this->update($order, [
            'discount' => $getAmount['discount'],
            'amount' => $getAmount['subTotal'],
            'total_amount' => $getAmount['total'],
        ]);
        $order->products()->detach($order->products->pluck('id')->toArray());

        foreach ($request->products as $product) {
            $order->products()->attach($product['id'], ['quantity' => $product['quantity']]);
        }

        return $order;
    }

    private function getAmount($request): array
    {
        $totalAmount = 0;
        foreach ($request->products as $item) {
            // if ($item['is_product']) {
                $product = (new ProductRepository())->findById($item['id']);
                $price = $product->discount_price ?? $product->price;
                $totalAmount += (int)$item['quantity'] * $price;
            // } else {
            //     $subProduct = SubProduct::find($item['id']);
            //     $totalAmount += (int)$item['quantity'] * $subProduct?->price;
            // }
        }

        $totalServiceAmount = 0;
        if ($request->has('additional_service_id')) {
            $totalServiceAmount = Additional::whereIn('id', $request->additional_service_id)->get()->sum('price');
        }

        $total = ($totalAmount + $totalServiceAmount);
        $coupon = (new CouponRepository())->findById($request->coupon_id);
        $couponDiscount = $coupon ? $coupon->calculate($total, $coupon) : 0;

        $deliveryCost = DeliveryCost::first();
        $freeDelivery = $deliveryCost ? $deliveryCost->fee_cost : 0;
        $deliveryCharge = $deliveryCost ? $deliveryCost->cost : 0;

        $total = $total <= $freeDelivery ? $total + $deliveryCharge : $total;
        $total = $total - $couponDiscount;

        return [
            'total' => $total,
            'discount' => $couponDiscount,
            'subTotal' => ($totalAmount + $totalServiceAmount),
            'deliveryCharge' => $deliveryCharge
        ];
    }

    public function getSortedByRequest(Request $request)
    {

        $searchKey = $request->search;

        $orders = $this->model()::query();

        $customer = auth()->user()->customer;


        if($customer != NULL){
            dd($customer, $customer->id);
            $orders = $orders->where('customer_id', $customer->id);
        }


        if ($searchKey) {
            $orders = $orders->where(function ($query) use ($searchKey) {
                $query->orWhere('nama_customer', 'like', "%{$searchKey}%")
                    ->orWhereHas('customer', function ($customer) use ($searchKey) {
                        $customer->whereHas('user', function ($user) use ($searchKey) {
                            $user->where('first_name', $searchKey)
                                ->orWhere('last_name', $searchKey)
                                ->orWhere('mobile', $searchKey);
                        });
                    })
                    ->orWhere('nama_barang', 'like', "%{$searchKey}%");
            });
        }
        return $orders->latest()->get();
    }

    public function orderListByStatus($status = null)
    {
        $customer = auth()->user()->customer;
        $orders = $this->query()->where('customer_id', $customer->id);

        if ($status) {
            $orders = $orders->where('order_status', $status);
        }

        return $orders->latest()->get();
    }

    public function statusUpdateByRequest(Order $order, $status): Order
    {
        $order->update([
            'order_status' => $status,
        ]);

        $drivers = $order->drivers;

        if ($drivers && $status == config('enums.order_status.delivered') || $status == config('enums.order_status.picked_order')) {
            foreach ($drivers as $driver) {
                $driver->orderHistories()->attach($driver->pivot->order_id, ['status' => $driver->pivot->status]);
                $order->drivers()->detach($driver->id);
            }
        }
        return $order;
    }

    public function getRevenueReportByBetweenDate($form, $to)
    {
        return  $this->model()::whereBetween('delivery_date', [$form, $to])
            ->where('order_status', config('enums.order_status.delivered'))
            ->get();
    }

    public function getRevenueReport()
    {
        $year = now()->format('Y');
        $month = now()->format('m');

        $orders = $this->model()::where('order_status', config('enums.order_status.delivered'));
        if (request()->type == 'month') {

            $orders = $orders->whereMonth('delivery_date', $month)
                ->whereYear('delivery_date', $year);
        } elseif (request()->type  ==  'year') {

            $orders = $orders->whereYear('delivery_date', $year);
        } elseif (request()->type == 'week') {

            $end = now()->format('Y-m-d');
            $start = now()->subWeek()->format('Y-m-d');
            $orders = $orders->whereBetween('delivery_date', [$start, $end]);
        } else {

            $date = now()->format('Y-m-d');
            $orders = $orders->where('delivery_date', $date);
        }
        return  $orders->get();
    }

    public function getByDatePickOrDelivery($date, $type = 'picked')
    {
        $orders = $this->model()::query();

        if ($type == 'picked') {
            $orders = $orders->where('pick_date', $date);
        }

        if ($type == 'delivery') {
            $orders = $orders->where('delivery_date', $date);
        }

        return $orders->get();
    }

    public function findById($id)
    {
        return $this->model()::find($id);
    }

    public function setPickOrDeliveryTime($date, $times, $type = 'picked')
    {
        $times = explode('-', $times);

        foreach ($times as $time) {
            $orders = $this->model()::query();
            if ($type == 'picked') {
                $orders = $orders->where('pick_date', $date)->where('pick_hour', 'LIKE', "%$time%");
            }

            if ($type == 'delivery') {
                $orders = $orders->where('delivery_date', $date)->where('delivery_hour', 'LIKE', "%$time%");
            }

            if ($orders->count() < 2) {
                return sprintf('%02s', $time) . ':' . sprintf('%02s', ($orders->count() * 30)) . ':00';
            }
        }
    }
}
