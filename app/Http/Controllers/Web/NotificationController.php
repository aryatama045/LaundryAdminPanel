<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationRequest;
use App\Models\Customer;
use App\Models\DeviceKey;
use App\Repositories\CustomerRepository;
use App\Repositories\DeviceKeyRepository;
use App\Repositories\NotificationRepository;
use App\Services\NotificationServices;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $customers = (new CustomerRepository())->getAll();

        $device_type = request()->device_type;
        if ($device_type && $device_type != 'all') {
            $customers = Customer::whereHas('devices', function ($device) use ($device_type) {
                $device->where('device_type', $device_type);
            })->get();
        }

        return view('notifications.index', compact('customers'));
    }

    public function sendNotification(NotificationRequest $request)
    {
        $message = $request->message;
        $title = $request->title;
        $customers = $request->customer;

        $keys = DeviceKey::whereIn('customer_id', $customers)->pluck('key')->toArray();

        (new NotificationServices($message, $keys, $title));

        foreach ($customers as $customerID) {
            $customer = Customer::find($customerID);
            (new NotificationRepository())->storeByRequest($customer->id,$message,$title);
        }

        return back()->with('success', 'Send Successfully');
    }
}
