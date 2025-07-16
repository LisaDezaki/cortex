<?php

namespace App\Http\Resources;

// use App\Models\RegionResource;
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
			'id'           => $this->id,
			'slug'         => $this->slug,
			'name'         => $this->name,
			'description'  => $this->description,
			'image'       => $this->image,
			'image_path'   => $this->image ? Storage::url($this->image) : null,

			'coordinates'  => [
				'x' => $this->coordinates_x,
				'y' => $this->coordinates_y
			],

			'characters'  => CharacterResource::collection($this->whenLoaded('characters')),
			'region'      => new RegionResource($this->whenLoaded('region')),

			'meta' => [
				'created_at' => $this->created_at,
				'updated_at' => $this->updated_at
			]
		];
    }
}