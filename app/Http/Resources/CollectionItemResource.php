<?php

namespace App\Http\Resources;

use App\Models\Character;
use App\Models\Faction;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CollectionItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
		$item = $this->collectionable_type::where([
					'id' => $this->collectionable_id
				])->with(['image'])->first();

		$item = match ($this->collectionable_type) {
			Character::class	=>	new CharacterResource($item),
			Faction::class		=>	new FactionResource($item),
			Location::class		=>	new LocationResource($item),
		};

		return [
			'collectionable_id'		=> $this->collectionable_id,
			'collectionable_type'	=> $this->collectionable_type,
			'order'					=> $this->order,
			'notes'					=> $this->notes,
			'item'					=> $item
		];
    }
}