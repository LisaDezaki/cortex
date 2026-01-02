<?php

namespace App\Http\Resources;

use App\Models\Character;
use App\Models\CustomField;
use App\Models\Faction;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
		return [
			'id'     => $this->id,
			'name'   => $this->name,
			'email'  => $this->email,

			'image' => new MediaResource($this->whenLoaded('image')),
			'media' => MediaResource::collection($this->whenLoaded('media')),

			'projects' => ProjectResource::collection($this->whenLoaded('projects')),

			'meta' => [
				'email_verified_at' => $this->email_verified_at,
				'created' => [
					'at'  => $this->created_at,
					'ago' => $this->created_at->diffForHumans()
				],
				'updated' => [
					'at'  => $this->updated_at,
					'ago' => $this->updated_at->diffForHumans()
				]
			]
		];
    }
}