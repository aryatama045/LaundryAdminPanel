<?php

namespace Database\Seeders;

use App\Models\NotificationManage;
use Illuminate\Database\Seeder;

class NotificationManageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'title' => 'New Order',
                'name' => 'new_order',
                'message' => 'New Order has been placed',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Coupon Notification',
                'name' => 'coupon_notify',
                'message' => 'Get Product discount Coupon',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Order Confirmed',
                'name' => 'order_confirmed',
                'message' => 'Your order has been confirmed',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Order Picked',
                'name' => 'order_picked',
                'message' => 'Your order has been picked by delivery boy',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Order Processing',
                'name' => 'order_processing',
                'message' => 'Your order has been processed',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Order Cancelled',
                'name' => 'order_cancelled',
                'message' => 'Your order has been cancelled',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Order Delivered',
                'name' => 'order_delivered',
                'message' => 'Your order has been delivered successfully',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Driver Assigned',
                'name' => 'driver_assigned',
                'message' => 'Delivery boy has been assigned to your order',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        NotificationManage::truncate();

        NotificationManage::insert($data);
    }
}
