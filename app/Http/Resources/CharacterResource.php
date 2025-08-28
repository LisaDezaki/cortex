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
			'description' => $this->description,
			'appearance'  => $this->appearance,
			'personality' => $this->personality,
			'motivations' => $this->motivations,
			'flaws'       => $this->flaws,

			'media'		  => MediaResource::collection($this->whenLoaded('media')),

			'banner'      => new MediaResource($this->whenLoaded('banner')),
			'portrait'    => new MediaResource($this->whenLoaded('portrait')),
			'location'    => new LocationResource($this->whenLoaded('location')),
			'factions'    => FactionResource::collection($this->whenLoaded('factions')),
			'relationships' => CharacterRelationshipResource::collection($this->whenLoaded('relationships', function() {
				return $this->relationships->merge($this->inverseRelationships)->sortBy('name');
			})),
			'customFieldValues' => CustomFieldValueResource::collection($this->whenLoaded('customFieldValues')),

			'meta' => [
				'projectId' => $this->project_id,
				'createdAt' => $this->created_at,
				'updatedAt' => $this->updated_at
			]
		];
    }

	/**
	 * Get the resource's additional data.
	 *
	 * @return array<string, mixed>
	 */
	// public function with(Request $request): array
	// {
	// 	return [
	// 		'links' => [
	// 			'self' => route('characters.show', ['character' => $this->id]),
	// 		],
	// 	];
	// }
}