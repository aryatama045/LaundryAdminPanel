<?php

namespace Database\Seeders;

use App\Models\Additional;
use App\Models\AdditionalService;
use App\Models\Product;
use App\Models\Service;
use Faker\Factory;
use Illuminate\Database\Seeder;

class AdditionalServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $additionals = Additional::pluck('id')->toArray();
        foreach(Service::all() as $service){
            $service->additionals()->sync($faker->randomElements($additionals, 5));
        }
    }
}
