<?php

namespace App\Http\Resources;

use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
			'subtitle'    => $this->subtitle,
			'description' => $this->description,
			'appearance'  => $this->appearance,
			'personality' => $this->personality,
			'motivations' => $this->motivations,
			'flaws'       => $this->flaws,
			'image'       => $this->image,
			'image_path'  => $this->image ? Storage::url($this->image) : null,

			'location'    => new LocationResource($this->whenLoaded('location')),
			'factions'    => FactionResource::collection($this->whenLoaded('factions')),
			'relationships' => CharacterRelationshipResource::collection($this->whenLoaded('relationships', function() {
				return $this->relationships->merge($this->inverseRelationships)->sortBy('name');
			})),

			// 'custom_fields'       => CustomFieldResource::collection($this->whenLoaded('customFields')),
			'custom_field_values' => CustomFieldValueResource::collection($this->whenLoaded('customFieldValues')),

			'meta' => [
				'project_id' => $this->project_id,
				'created_at' => $this->created_at,
				'updated_at' => $this->updated_at
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