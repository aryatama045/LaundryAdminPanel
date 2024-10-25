<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerGaransis extends Model
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


    public function devices()
    {
        return $this->hasMany(DeviceKey::class);
    }


    // ----------------- Attribute
    public function getGaransiPhotoPathAttribute()
    {
        return $this->bukti_foto->GaransiPhotoPath;
    }

    public function getNameAttribute()
    {
        return $this->user->first_name . ' ' . $this->user->last_name;
    }
}
