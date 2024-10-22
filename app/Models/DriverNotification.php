<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverNotification extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }
    
}
