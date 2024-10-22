<?php

namespace App\Http\Resources;

use App\Models\DeliveryCost;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $quantity = collect([]);
        foreach($this->products as $product){
            $quantity[$product->id] = (int)$product->pivot->quantity;
        }

        if ($this->order_status != 'Delivered') {
            $hasDriver = $this->drivers->isEmpty() ? false : true;
        }
        if ($this->order_status == 'Delivered') {
            $hasDriver = true;
        }

        $payment_url = null;
        if (config('app.stripe_key') && config('app.stripe_secret')) {
            $payment_url = route('payment','orderId='.$this->id);
        }

        App::setLocale('ar');

        return [
            'id' => $this->id,
            'order_code' => $this->order_code,
            'driver_status' => $this->pivot ? $this->pivot->status : null,
            'drivers' => $hasDriver,
            'customer' => (new CustomerResource($this->customer)),
            'discount' => (int) $this->discount,
            'amount' => (int) $this->amount,
            'total_amount' => (int) $this->total_amount,
            'delivery_charge' => (int) $this->delivery_charge ?? 0,
            'order_status' => $this->order_status,
            'order_status_bn' => __($this->order_status),
            'payment_status' => $this->payment_status,
            'payment_status_bn' => __($this->payment_status),
            'payment_type' => $this->payment_type,
            'payment_type_bn' => __($this->payment_type),
            'pick_date' => Carbon::parse($this->pick_date)->format('d F, Y'),
            'pick_hour' => $this->getTime(substr($this->pick_hour, 0, 2)),
            'delivery_date' => Carbon::parse($this->delivery_date)->format('d F, Y'),
            'delivery_hour' => $this->getTime(substr($this->delivery_hour, 0, 2)),
            'ordered_at' => $this->created_at->format('Y-m-d h:i a'),
            'rating' => $this->rating ? $this->rating->rating : null,
            'item' => $this->products->count(),
            'address' => (new AddressResource($this->address)),
            'products' => ProductResource::collection($this->products),
            'quantity' => $quantity,
            'payment' => $this->payment ? (new PaymentResource($this->payment)) : null,
            'payment_url' => $payment_url
        ];
    }

    private function getTime($time)
    {
        $times = [
            '8' => '08-09:59',
            '9' => '08-09:59',
            '10' => '10-11:59',
            '11' => '10-11:59',
            '12' => '12-13:59',
            '13' => '12-13:59',
            '14' => '14-15:59',
            '15' => '14-15:59',
            '16' => '16-17:59',
            '17' => '16-17:59',
            '18' => '18-19:59',
            '19' => '18-19:59',
            '20' => '20-21:59',
            '21' => '20-21:59',
        ];
        foreach($times as $key => $item){
            if($key == $time){
                return $item;
            }
        }
    }
}
