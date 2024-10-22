<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'gender' => $this->gender,
            'mobile_verified_at' => $this->mobile_verified_at,
            'is_active' => (bool) $this->is_active ? true : false,
            'alternative_phone' => $this->alternative_phone,
            'profile_photo_path' => $this->profilePhotoPath,
            'driving_lience' => $this->driving_lience,
            'date_of_birth' => $this->date_of_birth ? Carbon::parse($this->date_of_birth)->format('d F, Y') : null,
            'join_date' => Carbon::parse($this->created_at)->format('d F, Y'),
        ];
    }
}
