<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, (new DriverOrder())->getTable())
            ->withPivot('is_accept', 'status')
            ->withTimestamps();
    }

    public function orderHistories()
    {
        return $this->belongsToMany(Order::class, (new DriverHistory())->getTable())
            ->withPivot('status')
            ->withTimestamps();
    }

    public function driverDevices()
    {
        return $this->hasMany(DriverDeviceKey::class);
    }

    // --------- scope ---------------
    public function scopeIsApprove(Builder $builder, $isApprove = true): Builder
    {
        return $builder->where('is_approve', $isApprove);
    }
}
