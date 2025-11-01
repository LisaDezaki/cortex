<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class MapItem extends Model
{
	use HasUuids;

	public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'id',
		'location_id',
		'mappable_id',
		'mappable_type',
		'x',
		'y',
	];


	/**
	 * Get the parent mappable model (Character, Faction, Location, etc.)
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\Relation
	 */
	public function mappable(): MorphTo
	{
		return $this->morphTo();
	}

	/**
     * Get the location that this map item belongs to
     */
	public function location(): BelongsTo
	{
		return $this->belongsTo(Location::class);
	}

}