<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvitationsResource extends JsonResource
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
            'id' => $this->id,
            'from' => $this->from,
            'to' => $this->to,
            'validated' => $this->validated,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'receiver' => $this->toUser,
            'transmitter' => $this->fromUser,
        ];
    }
}
