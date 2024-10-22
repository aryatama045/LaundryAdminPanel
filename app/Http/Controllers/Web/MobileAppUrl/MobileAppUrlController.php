<?php

namespace App\Http\Controllers\Web\MobileAppUrl;

use App\Http\Controllers\Controller;
use App\Models\MobileAppUrl;
use Illuminate\Http\Request;

class MobileAppUrlController extends Controller
{
    public function index()
    {
        $appLink = MobileAppUrl::first();
        return view('mobileAppUrl.index', compact('appLink'));
    }

    public function updateOrCreate(Request $request)
    {
        $appLink = MobileAppUrl::first();

        MobileAppUrl::updateOrCreate([
            'id' => $appLink ? $appLink->id : 0
        ],[
            'android_url' => $request->android_url,
            'ios_url' => $request->ios_url
        ]);

        return redirect()->back()->with('success', 'Updated Successfully');
    }
}
