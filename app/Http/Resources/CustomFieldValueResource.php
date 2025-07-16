<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomFieldValueResource extends JsonResource
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
			'custom_field_id' => $this->custom_field_id,
			'custom_field_label' => $this->whenLoaded('customField', function() {
				return $this->customField->label;
			}),
			'value' => $this->value,
		];
    }
}