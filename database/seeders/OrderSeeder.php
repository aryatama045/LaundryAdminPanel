<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Faker\Factory;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customrs = Customer::all();
        $coupons = Coupon::all();
        $faker = Factory::create();
        $min = ['00', 15, 30, 45];
        
        foreach($customrs as $key => $customr){
            for($i = 0; $i < rand(1, 10); $i++){
                $coupon = $faker->randomElement($coupons);
                Order::factory()->create([
                    'customer_id' => $customr->id,
                    'coupon_id' => $faker->randomElement($coupons)->id,
                    'discount' => $coupon->discount,
                    'pick_hour' => rand(0, 23) . ':'. $faker->randomElement($min) . ':00',
                    'delivery_hour' => rand(0, 23) . ':'. $faker->randomElement($min) . ':00',
                ]);
            }
        }

        $orders = Order::all();
        $producs = Product::isActive()->get();

        foreach($orders as $order){
            foreach($faker->randomElements($producs, rand(2, 10)) as $product){
                $order->products()->attach($product->id);
            }
        }
    }
}
