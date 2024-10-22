<?php

namespace Database\Factories;

use App\Models\Media;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'service_id' => 1,
            'variant_id' => 1,
            'thumbnail_id' => Media::factory()->create(),
            'name' => $this->faker->word,
            'slug' => $this->faker->slug(),
            'discount_price' => $this->faker->randomFloat(2, 10, 100),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
