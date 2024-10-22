<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Additional extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function services()
    {
        return $this->belongsToMany(Service::class, AdditionalService::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, (new AdditionalOrder())->getTable());
    }
}
