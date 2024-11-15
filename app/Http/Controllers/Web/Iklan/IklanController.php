<?php

namespace App\Http\Controllers\Web\Iklan;

use App\Http\Controllers\Controller;
use App\Http\Requests\IklanRequest;
// use App\Models\Iklan;
use App\Models\NotificationManage;
use App\Models\Order;
use App\Repositories\IklanRepository;
use App\Repositories\UserRepository;
use App\Services\NotificationServices;
use Illuminate\Http\Request;

class IklanController extends Controller
{
    public function index()
    {
        $iklan = (new IklanRepository())->getAllActive();
        if (request()->deactive) {
            $iklan = (new IklanRepository())->getAllDeactive();
        }
        return view('iklan.index', compact('iklan'));
    }

    public function create(Request $request)
    {
        return view('iklan.create');
    }

    public function store(IklanRequest $request)
    {
        $user = (new UserRepository())->registerUser($request);

        $driver = (new IklanRepository())->storeByUser($user);

        $user->assignRole('driver');

        $user->update([
            'mobile_verified_at' => now()
        ]);
        $driver->update([
            'is_approve' => true
        ]);

        return redirect()->route('driver.index')->with('success','Iklan add successfully');
    }



    public function details(Iklan $driver)
    {
        return view('iklan.show', compact('driver'));
    }


}
