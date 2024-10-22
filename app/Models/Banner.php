<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Banner extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    //------------ Relations
    public function thumbnail()
    {
        return $this->belongsTo(Media::class, 'thumbnail_id');
    }

    //----------- Attridutes
    public function getThumbnailPathAttribute()
    {
        if ($this->thumbnail && Storage::exists($this->thumbnail->src)) {
            return Storage::url($this->thumbnail->src);
        }
        return asset('images/dummy/dummy-placeholder.png');
    }

    //----------- Scope
    public function scopeIsActive(Builder $builder, bool $activity = true)
    {
        return $builder->where('is_active', $activity);
    }
}
