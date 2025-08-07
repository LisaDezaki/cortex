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
		return [
			'customFieldId' => $this->custom_field_id,
			'value' => $this->getDisplayValue(),
			'field' => new CustomFieldResource($this->whenLoaded('customField'))
		];
    }
}