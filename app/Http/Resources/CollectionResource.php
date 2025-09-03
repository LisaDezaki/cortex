<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CollectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
		return [
			'id'				=> $this->id,
			'slug'				=> $this->slug,
			'name'				=> $this->name,
			'description' 		=> $this->description,
			'collection_type' 	=> $this->collection_type,

			'items'				=> CollectionItemResource::collection($this->whenLoaded('items')),
			'characters'		=> CharacterResource::collection($this->whenLoaded('characters')),

			'items_count' => $this->whenLoaded('items', function () {
				return $this->items->count();
			}, function () {
				return 0;
			}),

			'meta'				=> [
				'projectId' 	=> $this->project_id,
			]
		];
    }
}
