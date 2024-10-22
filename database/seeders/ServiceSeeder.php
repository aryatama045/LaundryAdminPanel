<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Variant;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $variantIds = Variant::all()->pluck('id');

        $services =  Service::factory(3)->create();
        
        foreach($services as $service){
            $service->variants()->sync($variantIds);
        }
    }
}
