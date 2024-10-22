<?php

namespace App\Http\Controllers\Web\Products;

use App\Models\Coupon;
use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Models\NotificationManage;
use App\Models\WebSetting;
use App\Repositories\CouponRepository;
use App\Repositories\DeviceKeyRepository;
use App\Services\NotificationServices;
use Carbon\Carbon;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = (new CouponRepository())->getAll();

        return view('coupon.index', compact('coupons'));
    }

    public function create()
    {
        return view('coupon.create');
    }

    public function store(CouponRequest $request)
    {
        (new CouponRepository())->storeByRequest($request);

        if ($request->notify) {

            $notificationManage = NotificationManage::where('name', 'coupon_notify')->first();
            $keys = (new DeviceKeyRepository())->getAll()->pluck('key')->toArray();

            if ($notificationManage?->is_active) {
                $message = $notificationManage->message;
                (new NotificationServices($message, $keys, 'Coupon Discount'));
            }
        }

        return redirect()->route('coupon.index')->with('success', 'Coupon is added successfully.');
    }

    public function edit(Coupon $coupon)
    {
        return view('coupon.edit', compact('coupon'));
    }

    public function update(CouponRequest $request, Coupon $coupon)
    {
        (new CouponRepository())->updateByRequest($request, $coupon);

        if ($request->notify) {

            $notificationManage = NotificationManage::where('name', 'coupon_notify')->first();
            $keys = (new DeviceKeyRepository())->getAll()->pluck('key')->toArray();

            if ($notificationManage?->is_active) {
                $message = $notificationManage->message;
                (new NotificationServices($message, $keys, 'Coupon Discount'));
            }
        }

        return redirect()->route('coupon.index')->with('success', 'Coupon is updated successfully.');
    }
}
