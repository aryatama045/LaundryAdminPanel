<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function bukti_foto_get()
    {
        return $this->belongsTo(CustomerBuktiFotos::class, 'garansi_id');
    }


    public function getBuktiFotoPathGaransi()
    {
        return $this->bukti_foto_get->getBuktiFotoGaransi;
    }



}
