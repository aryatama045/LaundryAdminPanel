<?php

namespace App\Http\Controllers\API\Coupon;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplyCouponRequest;
use App\Http\Resources\CouponResource;
use App\Repositories\CouponRepository;
use Illuminate\Http\Response;

class CouponController extends Controller
{
    public function apply($couponCode, ApplyCouponRequest $request)
    {
        $coupon = (new CouponRepository())->findByCoupon($couponCode, $request->amount);

        if(!$coupon){
            return $this->json('Invalid coupon', [], Response::HTTP_BAD_REQUEST);
        }

        if($coupon->min_amount >= $request->amount){
            return $this->json('Minimum order price is '.$coupon->min_amount.' for this coupon', [], Response::HTTP_BAD_REQUEST);
        }

        return $this->json('Coupon applied successfully', [
            'coupon' => new CouponResource($coupon)
        ]);
    }
}
