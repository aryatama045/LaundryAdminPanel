<?php


namespace App\Repositories;

use App\Http\Requests\CouponRequest;
use App\Models\Coupon;

class CouponRepository extends Repository
{
    public function model()
    {
        return Coupon::class;
    }

    public function getAll()
    {
        return $this->model()::latest('id')->get();
    }

    public function storeByRequest(CouponRequest $request): Coupon
    {
        $startedAt = $request->start_date . ' ' . $request->start_time . ":00";
        $expiredAt = $request->expired_date . ' ' . $request->expired_time . ":00";

        return $this->model()::create([
            'code' => $request->code,
            'discount_type' => $request->discount_type,
            'discount' => $request->discount,
            'started_at' =>  $startedAt,
            'min_amount' => $request->min_amount,
            'expired_at' => $expiredAt,
        ]);
    }

    public function updateByRequest(CouponRequest $request,  Coupon $coupon): Coupon
    {
        $startedAt = $request->start_date . ' ' . $request->start_time . ":00";
        $expiredAt = $request->expired_date . ' ' . $request->expired_time . ":00";

        $coupon->update([
            'code' => $request->code,
            'discount_type' => $request->discount_type,
            'discount' => $request->discount,
            'started_at' =>  $startedAt,
            'min_amount' => $request->min_amount,
            'expired_at' => $expiredAt,
        ]);
        return $coupon;
    }

    public function findByCoupon($coupon, $amount)
    {
        return $this->model()::where('code', 'like', "%$coupon%")->isValid($amount)->first();
    }

    public function findById($id)
    {
        return $this->model()::find($id);
    }
}
