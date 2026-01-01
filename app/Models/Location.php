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

class Location extends Model
{
	use HasUuids, HasFactory, Sluggable, SoftDeletes;



	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'name',
		'type',
		'description',
		'starred',
		'is_world_map',
		'banner',
		'map'
	];

	protected $casts = [
		'is_world_map' => 'boolean',
	];



	/**
	 * The attributes that should not be mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $guarded = [
	];



	/**
	 * Set up character relationships.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\Relation
	 */
	public function project(): BelongsTo
	{
		return $this->belongsTo(Project::class, 'project_id');
	}

	// public function hasParent(): bool
	// {
	// 	return !is_null($this->parent_location_id);
	// }
	// public function parent(): BelongsTo
    // {
    //     return $this->belongsTo(Location::class, 'parent_location_id');
    // }
	public function ancestors()
	{
		return $this->parent()->with('ancestors');
	}

	public function hasChildren(): bool
	{
		return $this->children()->exists();
	}
	// public function children(): HasMany
    // {
    //     return $this->hasMany(Location::class, 'parent_location_id');
    // }
	public function descendants()
	{
		return $this->children()->with('descendants');
	}

	public function getWorldMap()
	{
		return self::where('project_id', $this->project_id)
				->where('is_world_map', true)
				->first();
	}

	public function getWorldTree()
	{
		$worldMap = $this->getWorldMap();
		
		if ($worldMap) {
			return $worldMap->load('descendants');
		}
		
		return null;
	}

	// Get all descendants (requires recursive query or package like 'baum/baum')
	

	// Get all ancestors (requires recursive query)
	



	public function characters(): HasMany
	{
		return $this->hasMany(Character::class, 'location_id');
	}

	public function factionHeadquarters(): HasMany
	{
		return $this->hasMany(Faction::class, 'headquarters_id');
	}

	public function customFields(): MorphMany
	{
		return $this->morphMany(CustomField::class, 'fieldable');
	}

	public function customFieldValues(): HasMany
	{
		return $this->hasMany(CustomFieldValue::class, 'fieldable_id');
	}

	public function mapData(): MorphOne
	{
		return $this->morphOne(MapItem::class, 'mappable');
	}
	
	public function mapItems(): HasMany
	{
		return $this->hasMany(MapItem::class, 'location_id');
	}


	/**
	 * Media relationships.
	 * @return \Illuminate\Database\Eloquent\Relations\Relation
	 */

	public function image()
	{
		return $this->banner();
	}
	public function media(): MorphMany
	{
		return $this->morphMany(Media::class, 'mediable');
	}
	public function banner(): MorphOne
	{
		return $this->morphOne(Media::class, 'mediable')->where('type', 'banner');
	}
	public function map()
	{
		return $this->morphOne(Media::class, 'mediable')->where('type', 'map');
	}
	public function gallery(): MorphMany
	{
		return $this->morphMany(Media::class, 'mediable')->where('type', 'gallery');
	}
	



	/**
	 * Return the sluggable configuration array for this model.
	 *
	 * @return array
	 */
	public function sluggable(): array
	{
		return [
			'slug' => [
				'source' => 'name'
			]
		];
	}



	/**
	 * Return the sluggable configuration array for this model.
	 *
	 * @return string
	 */
	public function getRouteKeyName(): string
	{
		return 'slug';
	}



}
