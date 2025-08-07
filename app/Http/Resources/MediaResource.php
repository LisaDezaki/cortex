<?php

namespace App\Http\Resources;

use App\Models\Character;
use App\Models\CustomField;
use App\Models\Faction;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MediaResource extends JsonResource
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
			'path'   => $this->path,
			'type'   => $this->type,
			'url'    => Storage::url($this->path)
		];
    }
}