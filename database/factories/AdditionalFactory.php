<?php

namespace Database\Factories;

use App\Models\Additional;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdditionalFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Additional::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word(),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'is_active' => $this->faker->boolean(),
            'description' => $this->faker->sentence()
        ];
    }
}
