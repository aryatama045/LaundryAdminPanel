<?php

namespace Database\Seeders;

use App\Models\AdditionalOrder;
use App\Models\Address;
use App\Models\CardInfo;
use App\Models\Customer;
use App\Models\DeviceKey;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Payment;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserDeleteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        OrderProduct::query()->delete();
        Rating::query()->delete();
        AdditionalOrder::query()->delete();
        Payment::query()->delete();
        Order::query()->delete();
        Address::query()->forceDelete();
        DeviceKey::query()->delete();
        CardInfo::query()->delete();
        Notification::query()->delete();
        $customers = Customer::get();
        foreach ($customers as $customer) {
            $user = $customer->user;
            $customer->delete();
            $user->delete();
        }
    }
}
