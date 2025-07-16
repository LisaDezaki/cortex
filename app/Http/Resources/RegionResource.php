<?php

namespace App\Http\Resources;

// use App\Models\RegionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegionResource extends JsonResource
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
			'description' => $this->description,
			'image'       => $this->image,

			'locations'      => LocationResource::collection($this->whenLoaded('locations')),

			'meta' => [
				'project_id'  => $this->project_id,
				'created_at' => $this->created_at,
				'updated_at' => $this->updated_at
			]
		];
    }
}
