<?php

namespace App\Http\Controllers;

use App\Models\NotificationManage;
use Illuminate\Http\Request;

class NotificationManageController extends Controller
{
    public function index()
    {
        $notificationManage = NotificationManage::all();
        return view('notifications.manage', compact('notificationManage'));
    }

    public function update(Request $request, NotificationManage $notificationManage)
    {
        $request->validate(['message' => 'required']);

        $notificationManage->update([
            'is_active' => $request->status ? true : false,
            'message' => $request->message
        ]);

        return back()->withSuccess('Notification Manage Update Successfully');
    }
}
