<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    public static $wrap = false;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            ...$this->only('id', 'name', 'role'),
            $this->mergeWhen($this->role == 'vendor', [
                ...$this->only('description',
                    'address',
                    'lat',
                    'lng',
                    'phone_no',
                    'opening_hours',
                    'publish_menu'),
                'menu_id' => $this->menu()->select('id', 'vendor_id')->first()->id
            ])
        ];
    }
}
