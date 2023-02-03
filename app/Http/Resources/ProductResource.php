<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'category_id' => $this->category_id,
            'vendor_id' => $this->vendor_id,
            'position' => $this->position,
            'thumb_image_url' => $this->thumb_image_url,
            'pricing_details' => $this->pricing_details ?? [],
            'pricing_types' => $this->pricing_types ?? []
        ];
    }
}
