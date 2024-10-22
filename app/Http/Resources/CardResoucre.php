<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CardResoucre extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'card_id' => $this['id'],
            'last_no' => $this['last4'],
            'brand' => $this['brand'],
            'expire_month' =>$this['exp_month'],
            'expire_year' => $this['exp_year'],
        ];
    }
}
