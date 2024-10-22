<?php

namespace App\Http\Controllers\API\Notifications;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationRequest;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use App\Repositories\NotificationRepository;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function index()
    {
        $notifications = (new NotificationRepository())->notificationListByStatus((int)\request('isRead'));
        return $this->json('Notification list',[
            'notification' => NotificationResource::collection($notifications)
        ]);
    }

    public function store(NotificationRequest $request)
    {
       $notification = (new NotificationRepository())->storeByRequest($request->customer_id,$request->message, $request->title);
       return $this->json('Notification added successfully',[
            'notification' => (new NotificationResource($notification))
        ]);
    }

    public function update(Notification $notification)
    {
        $notification = (new NotificationRepository())->readUpdateByRequest($notification);
        return $this->json('Notification read successfully',[
            'notification' => (new NotificationResource($notification))
        ]);
    }

    public function delete(Notification $notification)
    {
        $notification = (new NotificationRepository())->deleteByRequest($notification);
        return $this->json('Notification deleted successfully');
    }
}
