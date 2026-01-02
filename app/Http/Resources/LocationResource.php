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
			'climate'	  => $this->climate,
			'starred'	  => $this->starred,
			'isWorldMap'  => $this->is_world_map,

			'mapData'	  => new MapItemResource($this->whenLoaded('mapData')),
			'mapItems'	  => MapItemResource::Collection($this->whenLoaded('mapItems')),

			'image'		  => new MediaResource($this->whenLoaded('image')),
			'media'		  => MediaResource::collection($this->whenLoaded('media')),

			// 'banner'      => new MediaResource($this->whenLoaded('banner')),
			// 'gallery'     => MediaResource::collection($this->whenLoaded('gallery')),
			// 'map'         => new MediaResource($this->whenLoaded('map')),
			
			// 'parent'      => new LocationResource($this->whenLoaded('parent')),
			// 'children'    => LocationResource::collection($this->whenLoaded('children')),
			// 'ancestors' => LocationResource::collection($this->whenLoaded('ancestors')),
			// 'descendants' => LocationResource::collection($this->whenLoaded('descendants')),

			// 'coordinates' => [
			// 	'x' => $this->coordinates_x,
			// 	'y' => $this->coordinates_y
			// ],

			'characters'  => CharacterResource::collection($this->whenLoaded('characters')),
			'customFieldValues' => CustomFieldValueResource::collection($this->whenLoaded('customFieldValues')),

			'meta' => [
				'projectId' => $this->project_id,
				'created' => [
					'at'  => $this->created_at,
					'ago' => $this->created_at->diffForHumans()
				],
				'updated' => [
					'at'  => $this->updated_at,
					'ago' => $this->updated_at->diffForHumans()
				]
			],

			'routes' => [
				'show'    => route('locations.show',    ['location' => $this->slug]),
				'update'  => route('locations.update',  ['location' => $this->slug]),
				'destroy' => route('locations.destroy', ['location' => $this->slug])
			]
		];
    }
}