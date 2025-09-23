<?php

namespace App\Http\Resources;

use App\Models\Pivots\FactionMember;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class FactionMemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
		return [
			'slug'         => $this->slug,
			'name'         => $this->name,
			'description'  => $this->description,

			'image'        => new MediaResource($this->whenLoaded('image')),
			'rank'         => new FactionRankResource($this->pivot->rank)
		];
    }
}