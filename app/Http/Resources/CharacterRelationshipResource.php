<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CharacterRelationshipResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

		return [
			'id'          => $this->id,
			'slug'        => $this->slug,
			'name'        => $this->name,
			'description' => $this->description,
			'image'       => $this->image,
			'image_path'  => $this->image ? Storage::url($this->image) : null,

			'role'		  => $this->whenLoaded('pivot', function() {
				return $this->id === $this->pivot->character_id
					? $this->pivot->character_role
					: $this->pivot->related_character_role;
			}),
		];
    }
}
