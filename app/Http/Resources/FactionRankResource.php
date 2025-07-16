<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FactionRankResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
			'id'           => $this->id,
			'order'        => $this->order,
			'name'         => $this->name,
			'description'  => $this->description,

			'members'      => FactionMemberResource::collection($this->whenLoaded('members')),
		];
    }
}