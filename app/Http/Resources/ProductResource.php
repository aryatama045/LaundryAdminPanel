<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $discount = null;
        if($this->price > $this->discount_price && $this->discount_price > 0){
            $percentage = ceil(($this->discount_price - $this->price) / $this->price * 100);
            $incrementOrDecrement = substr($percentage, 0 ,1);
            if($incrementOrDecrement == '-'){
                $discount = $percentage;
            }
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'name_bn' => $this->name_bn,
            'slug' => $this->slug,
            'current_price' => (int) ($this->discount_price ? $this->discount_price :  $this->price),
            'old_price' => (int) ($this->discount_price ? $this->price : 0),
            'description' => $this->description,
            'image_path' => $this->thumbnailPath,
            'discount_percentage' => $discount,
            'sub_products' => SubProductResource::collection($this->subProducts),
            'service' => (new ServiceResource($this->service)),
            'variant' => (new VariantResource($this->variant))
        ];
    }
}
