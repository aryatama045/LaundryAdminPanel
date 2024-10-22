<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\OrderSchedule;
use App\Repositories\ScheduleRepository;
use Illuminate\Http\Request;

class OrderScheduleController extends Controller
{
    public function index($type)
    {
        $schedules = (new ScheduleRepository())->getByType($type);

        return view('schedule.index', compact('schedules', 'type'));
    }

    public function updateStatus($id)
    {
        $schedule = (new ScheduleRepository())->find($id);
        $schedule->update([
            'is_active' => !$schedule->is_active
        ]);

        return back()->with('success', 'Off day is updated successfull.');
    }

    public function update(Request $request, OrderSchedule $orderSchedule)
    {
        $request->validate([
            "start_time" => "required",
            "end_time" => "required",
            "per_hour" => 'required|numeric'
        ]);

        (new ScheduleRepository())->update($orderSchedule,[
            "start_time" => (int) explode(':', $request->start_time)[0],
            "end_time" => (int) explode(':', $request->end_time)[0],
            "per_hour" => $request->per_hour
        ]);

        return back()->with('success', 'Schedule is updated successful.');
    }
}
