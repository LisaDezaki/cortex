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
			'fieldId' 		=> $this->custom_field_id,
			'name' 			=> $this->whenLoaded('customField', $this->customField->name),
			'label' 		=> $this->whenLoaded('customField', $this->customField->label),
			'description' 	=> $this->whenLoaded('customField', $this->customField->description),
			'placeholder' 	=> $this->whenLoaded('customField', $this->customField->placeholder),
			'value' 		=> $this->value,
			'displayValue' 	=> $this->getDisplayValue(),
			'options' 		=> CustomFieldOptionResource::collection($this->whenLoaded('customField', $this->customField->options)),
		];
    }
}