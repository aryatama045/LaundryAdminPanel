<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $address_name = ['Home', 'office', 'other'];
        return [
            'customer_id' => 1,
            'address_name' => $this->faker->randomElement($address_name),
            'road_no' => $this->faker->streetName(),
            'house_no' => $this->faker->randomNumber(),
            'flat_no' => $this->faker->randomDigitNotZero(),
            'block' => $this->faker->word(),
            'area' => 'Basundhara',
            'sub_district_id' => null,
            'district_id' => null,
            'address_line' => $this->faker->streetAddress(),
            'address_line2' => $this->faker->streetAddress(),
            'delivery_note' => $this->faker->text(),
            'post_code' => $this->faker->postcode(),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
        ];
    }
}
