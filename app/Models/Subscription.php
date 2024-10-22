<?php

namespace App\Models;

use App\Enum\ValidityTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $casts = [
        'validity_type' => ValidityTypeEnum::class
    ];
}
