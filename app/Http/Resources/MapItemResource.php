<?php

namespace App\Http\Resources;

use App\Models\Character;
use App\Models\Faction;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MapItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
		return [
			'x' => $this->x,
			'y' => $this->y,
			'location' => new LocationResource($this->whenLoaded('location')),
			'type' => $this->whenLoaded('mappable', function() {
				switch ($this->mappable_type) {
					case Character::class:
						return 'character';
					case Faction::class:
						return 'faction';
					case Location::class:
						return 'location';
					default:
						
				}
			}),
			'mappable' => $this->whenLoaded('mappable', function() {
				switch ($this->mappable_type) {
					case Character::class:
						return new CharacterResource($this->mappable);
					case Faction::class:
						return new FactionResource($this->mappable);
					case Location::class:
						return new LocationResource($this->mappable);
					default:
						
				}
			})
		];
    }
}