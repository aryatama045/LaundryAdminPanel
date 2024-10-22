<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Service;
use App\Models\Variant;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Service::all() as $service) {
            foreach (Variant::all() as $variant) {
                Product::factory(rand(5, 15))->create([
                    'service_id' => $service->id,
                    'variant_id' => $variant->id,
                ]);
            }
        }
    }
}
