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

			'recipes'	  => ItemRecipeResource::collection($this->whenLoaded('recipes')),
			
			'customFieldValues' => CustomFieldValueResource::collection($this->whenLoaded('customFieldValues')),

			'consumable' => json_decode($this->consumable, true),
			'craftable'  => json_decode($this->craftable, true),
			'equippable' => json_decode($this->equippable, true),
			'scrappable' => json_decode($this->scrappable, true),
			'throwable'  => json_decode($this->throwable, true),
			'weaponable' => json_decode($this->weaponable, true),

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