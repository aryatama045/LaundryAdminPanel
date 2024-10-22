<?php

namespace Database\Seeders;

use App\Models\OrderSchedule;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        foreach ($days as $day) {
            OrderSchedule::create([
                'day' => $day,
                'start_time' => 8,
                'end_time' => 16,
                'per_hour' => 1,
                'is_active' => true,
                'type' => 'pickup'
            ]);
        }

        foreach ($days as $day) {
            OrderSchedule::create([
                'day' => $day,
                'start_time' => 8,
                'end_time' => 16,
                'per_hour' => 1,
                'is_active' => true,
                'type' => 'delivery'
            ]);
        }
    }
}
