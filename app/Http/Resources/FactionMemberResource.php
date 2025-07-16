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
			'image'        => $this->image,
			'image_path'  => $this->image ? Storage::url($this->image) : null,

			'rank'         => new FactionRankResource($this->pivot->rank)
		];
    }
}