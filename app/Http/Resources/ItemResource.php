<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
		return [
			'id'  			=> $this->id,
			'slug'			=> $this->slug,
			'name'			=> $this->name,
			'type'			=> $this->type,
			'starred'		=> $this->starred,
			'description'	=> $this->description,
			'cost'			=> $this->cost,
			'unique'		=> $this->unique,
			'weight'		=> $this->weight,

			'mapData'	  => new MapItemResource($this->whenLoaded('mapData')),

			'image'		  => new MediaResource($this->whenLoaded('image')),
			'media'		  => MediaResource::collection($this->whenLoaded('media')),

			'factions'    => FactionResource::collection($this->whenLoaded('factions')),
			
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
				'show'    => route('items.show',    ['item' => $this->slug]),
				'update'  => route('items.update',  ['item' => $this->slug]),
				'destroy' => route('items.destroy', ['item' => $this->slug])
			]
		];
    }
}