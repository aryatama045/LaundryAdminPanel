<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Rating;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = Order::all();

        foreach($orders as $order){
            Rating::factory()->create([
                'order_id' => $order->id,
                'customer_id' => $order->customer->id,
            ]);
        }
    }
}
