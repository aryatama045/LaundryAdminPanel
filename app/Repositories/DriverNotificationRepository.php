<?php


namespace App\Repositories;

use App\Models\DriverNotification;

class DriverNotificationRepository extends Repository
{
    public function model()
    {
        return DriverNotification::class;
    }

    public function getAll()
    {
        return $this->model()::all();
    }

    public function notificationListByStatus($read = null)
    {
        $driver = auth()->user()->driver;
        $notifications = $this->model()::where('driver_id', $driver->id);

        if ($read) {
            $notifications = $notifications->where('isRead', $read);
        }

        return $notifications->latest()->get();
    }

    public function storeByRequest($driverId,$message): DriverNotification
    {
        $notification = $this->model()::create([
            'driver_id' => $driverId,
            'message' => $message,
            'isRead' => (int)0
        ]);
        return $notification;
    }

    public function readUpdateByRequest(DriverNotification $notification): DriverNotification
    {
        $notification->update([
            'isRead' => 1
        ]);
        return $notification;
    }

    public function deleteByRequest(DriverNotification $notification): DriverNotification
    {
        $notification->delete();
        return $notification;
    }


}
