<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    //------------ Relations
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }

    public function thumbnail()
    {
        return $this->belongsTo(Media::class);
    }

    public function subProducts()
    {
        return $this->hasMany(Product::class, 'product_id');
    }

    //------------ Attributes
    public function getThumbnailPathAttribute()
    {
        if ($this->thumbnail && Storage::exists($this->thumbnail->src)) {
            return Storage::url($this->thumbnail->src);
        }
        return asset('images/dummy/dummy-placeholder.png');
    }

    //----------- Scopes
    public function scopeIsActive(Builder $builder, bool $activity = true)
    {
        return $builder->where('is_active', $activity);
    }
}
