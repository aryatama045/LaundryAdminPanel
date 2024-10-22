<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // ---------- Relations
    public function products()
    {
        return $this->hasMany(Product::class, 'variant_id');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, (new ServiceVariant())->getTable())->withTimestamps();
    }
}
