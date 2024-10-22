<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class FCMController extends Controller
{
    public function index()
    {
        return view('fcm');
    }

    public function update(Request $request)
    {
        $request->validate([
            'fcm_key' => 'required',
        ]);
        try {
            $this->setEnv('FCM_SERVER_KEY', $request->fcm_key);

            Artisan::call('config:clear');
            Artisan::call('cache:clear');

            return back()->with('success', 'FCM configuration is setuped successful');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('error', 'Failed to open stream Permission denied');
    }
}
