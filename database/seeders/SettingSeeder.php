<?php

namespace Database\Seeders;

use App\Models\Setting;
use Faker\Factory;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        foreach(config('enums.settings') as $key => $setting){
            Setting::create([
                'title' => $setting,
                'slug' => $key,
                'content' => $faker->paragraphs(5, true),
            ]);
        }
    }
}