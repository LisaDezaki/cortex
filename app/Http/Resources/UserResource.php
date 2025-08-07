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

			'avatar' => new MediaResource($this->whenLoaded('avatar')),
			'projects' => ProjectResource::collection($this->whenLoaded('projects')),

			'meta' => [
				'email_verified_at' => $this->email_verified_at,
				'created_at' => $this->created_at,
				'updated_at' => $this->updated_at
			]
		];
    }
}