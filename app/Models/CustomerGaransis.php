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
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function bukti_foto()
    {
        return $this->hasMany(CustomerBuktiFotos::class, 'garansi_id');
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

    public function GaransiPhoto(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'foto_id');
    }

    public function getBuktiFotoPathGaransi(): string
    {
        if ($this->GaransiPhoto && Storage::exists($this->GaransiPhoto->src)) {
            return Storage::url($this->GaransiPhoto->src);
        }

        return asset('images/dummy/dummy-user.png');
    }
}
