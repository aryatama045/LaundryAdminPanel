<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostCodeResource extends JsonResource
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
            'postcode' => $this->postcode,
            'postcode_inward' => $this->postcode_inward,
            'postcode_outward' => $this->postcode_outward,
            'post_town' => $this->post_town,
            'building_number' => $this->building_number,
            'building_name' => $this->building_name,
            'line_1' => $this->line_1,
            'line_2' => $this->line_2,
            'line_3' => $this->line_3,
        ];
    }
}
