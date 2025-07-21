<?php

namespace App\Http\Resources;

// use App\Models\RegionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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

			'banner'      => $this->banner,
			'banner_path' => $this->banner ? Storage::url($this->banner) : null,
			'map'         => $this->map,
			'map_path'    => $this->map ? Storage::url($this->map) : null,

			'locations'      => LocationResource::collection($this->whenLoaded('locations')),

			'meta' => [
				'project_id'  => $this->project_id,
				'created_at' => $this->created_at,
				'updated_at' => $this->updated_at
			]
		];
    }
}
