<?php

namespace App\Http\Controllers\Web\Driver;

use App\Http\Controllers\Controller;
use App\Http\Requests\DriverRequest;
use App\Models\Driver;
use App\Models\NotificationManage;
use App\Models\Order;
use App\Repositories\DriverRepository;
use App\Repositories\UserRepository;
use App\Services\NotificationServices;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = (new DriverRepository())->getAllActive();
        if (request()->deactive) {
            $drivers = (new DriverRepository())->getAllDeactive();
        }
        return view('drivers.index', compact('drivers'));
    }

    public function create(Request $request)
    {
        return view('drivers.create');
    }

    public function store(DriverRequest $request)
    {
        $user = (new UserRepository())->registerUser($request);

        $driver = (new DriverRepository())->storeByUser($user);

        $user->assignRole('driver');

        $user->update([
            'mobile_verified_at' => now()
        ]);
        $driver->update([
            'is_approve' => true
        ]);

        return redirect()->route('driver.index')->with('success','Driver add successfully');
    }

    public function driverAssign(Order $order, $driver)
    {

        $orderStatus = ($order->order_status == config('enums.order_status.pending') || $order->order_status == config('enums.order_status.order_confirmed')) ? 'pick-up' : 'delivery';
        $order->drivers()->attach($driver,['status' => $orderStatus]);

        $driver = (new DriverRepository())->findById($driver);
        $keys = $driver->driverDevices->pluck('key')->toArray();

        $message = "You have received a ".$orderStatus." request. Order ID: LM".$order->order_code;

        $notificationManage = NotificationManage::where('name', 'driver_assigned')->first();

        if ($notificationManage?->is_active) {

            (new NotificationServices($message, $keys, 'Assign Order'));
        }

        return redirect()->back()->with('success','Driver assign successfully');
    }

    public function details(Driver $driver)
    {
        return view('drivers.show', compact('driver'));
    }

    public function toggleStatus(Driver $driver)
    {
        $driver->update([
            'is_approve' => !$driver->is_approve
        ]);
        return back()->with('success','status update successfully');
    }
}
