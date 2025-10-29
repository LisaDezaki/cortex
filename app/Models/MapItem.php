<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class MapItem extends Model
{
	use HasUuids;



	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'location_id',
		'mappable_id',
		'mappable_type',
		'x',
		'y',
	];



	/**
	 * The attributes that should not be mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $guarded = [
	];



	/**
	 * Set up MapItem relationships.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\Relation
	 */
	public function location(): BelongsTo
	{
		return $this->belongsTo(Location::class, 'location_id');
	}

	// Relationship to any model
	public function mappable()
	{
		return $this->morphTo();
	}

}
