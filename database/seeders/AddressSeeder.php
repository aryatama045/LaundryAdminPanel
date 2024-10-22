<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Customer;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(Customer::all() as $customer){
            Address::factory(rand(1, 3))->create([
                'customer_id' => $customer->id
            ]);
        }
    }
}
