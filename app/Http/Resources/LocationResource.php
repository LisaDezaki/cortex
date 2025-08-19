<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class LocationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
		return [
			'id'          => $this->id,
			'slug'        => $this->slug,
			'name'        => $this->name,
			'type'        => $this->type,
			'icon'        => $this->icon,
			'description' => $this->description,
			'banner'      => new MediaResource($this->whenLoaded('banner')),
			'map'         => new MediaResource($this->whenLoaded('map')),

			'isWorldMap'  => $this->is_world_map,
			'parent'      => new LocationResource($this->whenLoaded('parent')),
			'children'    => LocationResource::collection($this->whenLoaded('children')),
			'descendants' => LocationResource::collection($this->whenLoaded('descendants')),

			'coordinates' => [
				'x' => $this->coordinates_x,
				'y' => $this->coordinates_y
			],

			'characters'  => CharacterResource::collection($this->whenLoaded('characters')),

			'meta' => [
				'created_at' => $this->created_at,
				'updated_at' => $this->updated_at
			]
		];
    }
}