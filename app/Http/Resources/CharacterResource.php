<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CharacterResource extends JsonResource
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
			'alias'       => $this->alias,
			'starred'	  => $this->starred,
			'description' => $this->description,
			'appearance'  => $this->appearance,
			'personality' => $this->personality,
			'motivations' => $this->motivations,
			'flaws'       => $this->flaws,

			'mapData'	  => new MapItemResource($this->whenLoaded('mapData')),

			'image'		  => new MediaResource($this->whenLoaded('image')),
			'media'		  => MediaResource::collection($this->whenLoaded('media')),
			// 'collections' => CollectionResource::collection($this->whenLoaded('collections')),

			// 'banner'      => new MediaResource($this->whenLoaded('banner')),
			// 'portrait'    => new MediaResource($this->whenLoaded('portrait')),
			// 'location'    => new LocationResource($this->whenLoaded('location')),
			'factions'    => FactionResource::collection($this->whenLoaded('factions')),

			'inventory'		=> $this->whenLoaded('inventory'),

			'relationships' => CharacterRelationshipResource::collection($this->whenLoaded('relationships', function() {
				return $this->relationships->merge($this->inverseRelationships)->sortBy('name');
			})),
			'customFieldValues' => CustomFieldValueResource::collection($this->whenLoaded('customFieldValues')),

			// 'location' => new LocationResource($this->whenLoaded('mapData.location')),

			// 'mapData' => $this->whenLoaded('mapData') ? [
			// 	'x' => $this->whenLoaded('mapData.x'),
			// 	'y' => $this->whenLoaded('mapData.y'),
			// 	'location' => new LocationResource($this->whenLoaded('mapData.location'))
			// ] : null,

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
				'show'    => route('characters.show',    ['character' => $this->slug]),
				'update'  => route('characters.update',  ['character' => $this->slug]),
				'destroy' => route('characters.destroy', ['character' => $this->slug])
			]
		];
    }
}