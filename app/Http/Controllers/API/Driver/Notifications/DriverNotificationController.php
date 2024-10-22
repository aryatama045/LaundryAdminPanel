<?php

namespace App\Http\Controllers\API\Driver\Notifications;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationRequest;
use App\Http\Resources\NotificationResource;
use App\Models\DriverNotification;
use App\Repositories\DriverNotificationRepository;

class DriverNotificationController extends Controller
{
    public function index()
    {
        $notifications = (new DriverNotificationRepository())->notificationListByStatus((int)\request('isRead'));
        return $this->json('Notification list',[
            'notification' => NotificationResource::collection($notifications)
        ]);
    }

    public function store(NotificationRequest $request)
    {
       $notification = (new DriverNotificationRepository())->storeByRequest($request->driver_id,$request->message);
       return $this->json('Notification added successfully',[
            'notification' => (new NotificationResource($notification))
        ]);
    }

    public function update(DriverNotification $notification)
    {
        $notification = (new DriverNotificationRepository())->readUpdateByRequest($notification);
        return $this->json('Notification read successfully',[
            'notification' => (new NotificationResource($notification))
        ]);
    }

    public function delete(DriverNotification $notification)
    {
        $notification = (new DriverNotificationRepository())->deleteByRequest($notification);
        return $this->json('Notification deleted successfully');
    }
}
