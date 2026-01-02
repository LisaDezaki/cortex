<?php

namespace App\Http\Resources;

use App\Models\Character;
use App\Models\CustomField;
use App\Models\Faction;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProjectResource extends JsonResource
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
			'name'        => $this->name,
			'type'        => $this->type,
			'description' => $this->description,

			'image' 		=> new MediaResource($this->whenLoaded('image')),
			'banner' 		=> new MediaResource($this->whenLoaded('banner')),
			'media' 		=> MediaResource::collection($this->whenLoaded('media')),

			'characters'	=> CharacterResource::collection($this->whenLoaded('characters', function() {
				return $this->characters->sortBy('name');
			})),

			'factions'		=> FactionResource::collection($this->whenLoaded('factions', function() {
				return $this->factions->sortBy('name');
			})),

			'items'			=> ItemResource::collection($this->whenLoaded('items', function() {
				return $this->items->sortBy('name');
			})),

			'locations'		=> LocationResource::collection($this->whenLoaded('locations', function() {
				return $this->locations->sortBy('name');
			})),

			'customFields'	=> CustomFieldResource::collection($this->whenLoaded('customFields')),
			
			'meta' => [
				'projectId' => $this->project_id,
				'created' => [
					'at'  => $this->created_at,
					'ago' => $this->created_at->diffForHumans()
				],
				'updated' => [
					'at'  => $this->updated_at,
					'ago' => $this->updated_at->diffForHumans()
				],
				// 'deleted' => [
				// 	'at'  => $this->deleted_at,
				// 	'ago' => $this->deleted_at->diffForHumans()
				// ]
			],
		];
    }
}