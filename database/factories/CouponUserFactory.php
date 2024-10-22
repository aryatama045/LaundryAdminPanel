<?php

namespace Database\Factories;

use App\Models\Coupon;
use App\Models\CouponUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CouponUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CouponUser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'coupon_id' => Coupon::factory()->create(),
            'user_id' => User::factory()->create()
        ];
    }
}
