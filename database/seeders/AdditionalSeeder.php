<?php

namespace Database\Seeders;

use App\Models\Additional;
use Illuminate\Database\Seeder;

class AdditionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Additional::factory(20)->create();
    }
}
