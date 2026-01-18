<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemRecipeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

		$components = json_decode($this->components, true);

		return [
			'id'  			=> $this->id,
			'type'			=> $this->type,
			// 'components'	=> $components,

			'components'	=> array_map(
				fn($qty, $key) => [
					'item' => $key,
					'quantity' => $qty,
				],
				$components,
				array_keys($components)
			),

			// 'components'	=> array_map(
			// 	fn($key, $qty) => ['item' => $key, 'quantity' => $qty],
			// 	json_decode($this->components, true),
			// ),

			'meta' => [
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