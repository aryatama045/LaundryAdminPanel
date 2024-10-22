<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'object' => $this->object,
            'brand' => $this->brand,
            'status' => $this->status,
            'exp' => $this->exp,
            'last_no' => $this->last_no,
            'transaction' => $this->transaction,
            'amount' => $this->amount,
        ];
    }
}
