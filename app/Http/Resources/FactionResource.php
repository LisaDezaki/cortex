<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
			'type'         => $this->type,
			'description'  => $this->description,
			'starred'	  => $this->starred,

			'image'		  => new MediaResource($this->whenLoaded('image')),
			'media'		  => MediaResource::collection($this->whenLoaded('media')),
			'banner'       => new MediaResource($this->whenLoaded('banner')),
			'emblem'       => new MediaResource($this->whenLoaded('emblem')),
			
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