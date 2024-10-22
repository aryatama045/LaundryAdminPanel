<?php

namespace Database\Factories;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CouponFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Coupon::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->randomNumber(8, true),
            'discount_type' => $this->faker->randomElement(config('enums.coupons.discount_types')),
            'discount' => $this->faker->randomFloat(2, 5,20),
            'min_amount' => $this->faker->randomFloat(2, 10,100),
            'started_at' => $this->faker->dateTime,
            'expired_at' => $this->faker->dateTime,
        ];
    }
}
