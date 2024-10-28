<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class CustomerBuktiFotos extends Model
{

    use HasFactory;
    protected $guarded = ['id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function garansi()
    {
        return $this->belongsTo(CustomerGaransis::class, 'garansi_id');
    }

    public function klaim()
    {
        return $this->belongsTo(CustomerKlaims::class, 'klaim_id');
    }

    public function getBuktiFotoPathGaransi()
    {
        return $this->garansi->profilePhotoPath;
    }

    public function getBuktiFotoPathKlaim()
    {
        return $this->klaim->profilePhotoPath;
    }


}
