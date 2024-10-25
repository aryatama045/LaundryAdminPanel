<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerKlaimGaransis extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    // ----------------- Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bukti_foto()
    {
        return $this->hasMany(CustomerBuktiFotos::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function devices()
    {
        return $this->hasMany(DeviceKey::class);
    }


    public function cards()
    {
        return $this->hasMany(CardInfo::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // ----------------- Attribute
    public function getProfilePhotoPathAttribute()
    {
        return $this->user->profilePhotoPath;
    }

    public function getNameAttribute()
    {
        return $this->user->first_name . ' ' . $this->user->last_name;
    }
}
