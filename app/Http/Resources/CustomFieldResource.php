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
			'order'		  => $this->order,
			'name'        => $this->name,
			'label'	      => $this->label,
			'default'	  => $this->default,
			'description' => $this->description,
			'placeholder' => $this->placeholder,
			'required'	  => $this->required,
			'fieldableType' => $this->fieldable_type,
			'min'			=> $this->min,
			'max'			=> $this->max,

			// 'options'     => CustomFieldOptionResource::collection($this->whenLoaded('options')),
			'options'     => CustomFieldOptionResource::collection($this->whenLoaded('options')),
		];
    }
}
