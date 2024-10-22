<?php

namespace Database\Factories;

use App\Models\Media;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail(),
            'mobile' => $this->faker->unique()->e164PhoneNumber,
            'email_verified_at' => now(),
            'mobile_verified_at' => now(),
            'password' => Hash::make('secret'), // secret
            'remember_token' => Str::random(10),
            'is_active' => $this->faker->boolean(),
            'profile_photo_id' => Media::factory()->create(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
                'mobile_verified_at' => null,
            ];
        });
    }
}
