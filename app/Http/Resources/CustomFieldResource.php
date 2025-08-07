<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomFieldResource extends JsonResource
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
			'type'		  => $this->type,
			'name'        => $this->name,
			'label'	      => $this->label,
			'description' => $this->description,
			'placeholder' => $this->placeholder,
			'required'	  => $this->required,
			'fieldable'   => $this->fieldable_type,

			'options'     => CustomFieldOptionResource::collection($this->whenLoaded('options')),
		];
    }
}
