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

			'banner' => new MediaResource($this->whenLoaded('banner')),

			'characters'  => CharacterResource::collection($this->whenLoaded('characters', function() {
				return $this->characters->sortBy('name');
			})),

			'factions'    => FactionResource::collection(  $this->whenLoaded('factions', function() {
				return $this->factions->sortBy('name');
			})),

			'locations'   => LocationResource::collection( $this->whenLoaded('locations', function() {
				return $this->locations->sortBy('name');
			})),

			'regions'     => RegionResource::collection( $this->whenLoaded('regions', function() {
				return $this->regions->sortBy('name');
			})),

			'customFields' => CustomFieldResource::collection($this->whenLoaded('customFields')),
			
			'meta' => [
				'created_at' => $this->created_at,
				'updated_at' => $this->updated_at,
				'deleted_at' => $this->deleted_at,
			]
		];
    }
}