<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $discount = $this->discount;

        return [
            'id' => $this->id,
            'code' => $this->code,
            'discount' => $discount,
            'min_amount' => $this->min_amount,
            'type' => $this->discount_type,
        ];
    }
}
