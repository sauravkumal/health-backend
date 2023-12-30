<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TelegramUserResource extends JsonResource
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
            ...$this->only(
                'id',
                'telegram_id',
                'first_name',
                'last_name',
                'display_name',
                'username',
                'dob',
                'gender',
                'created_at'
            ),
            'age' => $this->age];
    }
}
