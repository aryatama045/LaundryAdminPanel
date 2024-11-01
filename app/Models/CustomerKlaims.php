<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerKlaims extends Model
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
        return $this->hasMany(CustomerBuktiFotos::class, 'klaim_id');
    }

    public function bukti_foto_get()
    {
        return $this->belongsTo(CustomerBuktiFotos::class, 'klaim_id', 'foto_id');
    }


    public function getBuktiFotoPathKlaim()
    {
        return $this->bukti_foto_get->getBuktiFotoKlaim;
    }


    public function KlaimPhoto(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'foto_id');
    }


    public function getBuktiFotoKlaim(): string
    {
        if ($this->KlaimPhoto && Storage::exists($this->KlaimPhoto->src)) {
            return Storage::url($this->KlaimPhoto->src);
        }

        return asset('images/dummy/dummy-user.png');
    }





}
