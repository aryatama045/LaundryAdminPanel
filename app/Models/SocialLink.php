<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class SocialLink extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function photo(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'media_id');
    }

    public function getPhotoPathAttribute(): string
    {
        if ($this->photo && Storage::exists($this->photo->src)) {
            return Storage::url($this->photo->src);
        }

        return asset('images/dummy/dummy-user.png');
    }
}
