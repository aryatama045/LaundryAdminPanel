<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_id' => 1,
            'order_code' => rand(0000, 9999),
            'prefix' => 'IM',
            'coupon_id' => Coupon::factory()->create(),
            'discount' => $this->faker->randomFloat(2, 10, 100),
            'pick_date' => $this->faker->dateTimeBetween('-2 years', now())->format('Y-m-d'),
            'delivery_date' => $this->faker->dateTimeBetween('-1 years', now())->format('Y-m-d'),
            'amount' => $this->faker->randomFloat(2, 50, 500),
            'total_amount' => $this->faker->randomFloat(2, 50, 500),
            'payment_status' => $this->faker->randomElement(config('enums.payment_status')),
            'payment_type' => $this->faker->randomElement(config('enums.payment_types')),
            'order_status' => $this->faker->randomElement(config('enums.order_status')),
            'address_id' => Address::factory()->create(),
        ];
    }
}
