<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Coupon extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    //========= relationships ==============
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, (new CouponUser())->getTable())
            ->withTimestamps();
    }

    //----------- Scope
    public function scopeIsValid(Builder $builder, $minAmount): Builder
    {
        return $builder->where('min_amount', '<=', $minAmount)
            ->where('expired_at', '>=', now())
            ->where('started_at', '<=', now());
    }

    public static function calculate($total, $coupon)
    {
        if(!$coupon){
            return 0;
        }
        $discount = $coupon->discount;
        if($coupon->discount_type == 'percent'){
            $discount = ($total / 100) * $discount;
        }
        return $discount;
    }
}
