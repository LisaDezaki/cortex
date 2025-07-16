<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class FactionResource extends JsonResource
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
			'slug'         => $this->slug,
			'name'         => $this->name,
			'description'  => $this->description,
			'image'        => $this->image,
			'image_path'   => $this->image ? Storage::url($this->image) : null,

			'headquarters' => new LocationResource($this->whenLoaded('headquarters')),
			'members'      => FactionMemberResource::collection($this->whenLoaded('members')),
			'ranks'        => FactionRankResource::collection($this->whenLoaded('ranks')),

			'meta' => [
				'project_id' => $this->project_id,
				'created_at' => $this->created_at,
				'updated_at' => $this->updated_at
			]
		];
    }
}