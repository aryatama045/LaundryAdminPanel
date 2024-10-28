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
        return $this->belongsTo(User::class);
    }

    public function bukti_foto()
    {
        return $this->hasMany(CustomerBuktiFotos::class);
    }






}
