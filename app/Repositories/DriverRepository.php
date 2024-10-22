<?php


namespace App\Repositories;

use App\Http\Requests\ChangePasswordRequest;
use App\Models\Driver;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DriverRepository extends Repository
{
    public function model()
    {
        return Driver::class;
    }

    public function getAll()
    {
        return $this->model()::latest('id')->get();
    }
    public function getAllActive()
    {
        $drivers = $this->query();
        $active = 1;
        $drivers = $drivers->whereHas('user', function ($user) use ($active) {
            $user->where('is_active', $active);
        });

        return $drivers->latest('id')->get();
    }

    public function getAllByApprove()
    {
        $drivers = $this->query();
        $active = 1;
        $drivers = $drivers->whereHas('user', function ($user) use ($active) {
            $user->where('is_active', $active);
        });
        return $drivers->latest('id')->isApprove()->get();
    }

    public function getAllDeactive()
    {
        $drivers = $this->model()::query();
        $active = 0;
        $drivers = $drivers->whereHas('user', function ($user) use ($active) {
            $user->where('is_active', $active);
        });

        return $drivers->latest('id')->get();
    }

    public function findById($id)
    {
        return $this->model()::find($id);
    }

    public function getTodaysOrder()
    {
        $today = date('Y-m-d');
        $drive = auth()->user()->driver;
        $orders = $drive->orders();

        $orders = $orders->where('order_status', '!=', 'Delivered')
            ->where('pick_date', $today)
            ->orWhere('delivery_date', $today)
            ->wherePivot('is_accept', true)
            ->get();

        return $orders;
    }

    public function getTodaysOrderByRequest($status)
    {
        $today = date('Y-m-d');
        $drive = auth()->user()->driver;
        $orders = $drive->orders();

        $orders = $orders->where('pick_date', $today)
            ->orWhere('delivery_date', $today)
            ->wherePivot('is_accept', true)
            ->wherePivot('status', $status)
            ->get();

        return $orders;
    }

    public function getTodaysTotalPending()
    {
        $today = date('Y-m-d');
        $drive = auth()->user()->driver;
        $orders = $drive->orders();
        $orders = $orders->where('pick_date', $today)
            ->where('order_status', 'Pending')
            ->wherePivot('is_accept', true)
            ->get();

        return $orders;
    }

    public function getThisWeekDelivery()
    {
        $startDate = now()->startOfWeek()->format('Y-m-d');
        $endDate = now()->endOfWeek()->format('Y-m-d');

        $drive = auth()->user()->driver;
        $orders = $drive->orders();

        $orders = $orders->whereBetween('delivery_date', [$startDate, $endDate])
        ->where('order_status', '!=', 'Delivered')
        ->wherePivot('is_accept', true)
        ->wherePivot('status', 'delivery')
        ->get();

        return $orders;
    }

    public function getLastWeek()
    {
        $startDate = now()->subWeek()->startOfWeek()->format('Y-m-d');
        $endDate = now()->subWeek()->endOfWeek()->format('Y-m-d');

        $drive = auth()->user()->driver;
        $orders = $drive->orderHistories();

        return $orders->whereBetween('delivery_date', [$startDate, $endDate])
            ->orWhereBetween('delivery_date', [$startDate, $endDate])
            ->get();
    }

    public function getTotalOrder()
    {
        $drive = auth()->user()->driver;

        $is_accept = \request()->isAccept;

        $orders = $drive->orders()->wherePivot('is_accept', $is_accept)->get();

        return $orders;
    }

    public function storeByUser(User $user): Driver
    {
        return $this->model()::create([
            'user_id' => $user->id,
        ]);
    }

    public function changePasswordByRequest(ChangePasswordRequest $request, $user)
    {
        $currentPassword = $request->current_password;
        if (Hash::check($currentPassword, $user->password)) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);
            return $user;
        }
        return;
    }

    public function getAvailableDriverByRequest(Order $order)
    {
        $drivers = $this->getAllByApprove();

        $availableDrivers = [];

        foreach ($drivers as $driver) {
            $pickup = 0;
            $delivery = 0;
            foreach ($driver->orders as $driverOrder) {
                if ($driverOrder->pick_date == $order->pick_date && $driverOrder->getTime($driverOrder->pick_hour) == $order->getTime($order->pick_hour)) {
                    $pickup += 1;
                }
                if ($driverOrder->delivery_date == $order->delivery_date && $driverOrder->getTime($driverOrder->delivery_hour) == $order->getTime($order->delivery_hour)) {
                    $delivery += 1;
                }
            }
            if ($pickup < 4 || $delivery < 4) {

                $availableDrivers[] = $driver;
            }
        }

        return $availableDrivers;
    }
}
