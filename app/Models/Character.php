<?php

namespace App\Models;

use App\Models\CollectionItem;
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

class Character extends Model
{
	use HasUuids, HasFactory, Sluggable, SoftDeletes;

	protected $fillable = [
		'name',
		'alias',
		'subtitle',
		'description',
		'appearance',
		'personality',
		'motivations',
		'flaws',
		'location_id',
		'portrait_id'
	];

	protected $guarded = [
		'project_id'
	];

	protected $casts = [
		'name' => 'string',
	];



	/**
	 * Set up character relationships.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\Relation
	 */

	public function project(): BelongsTo
	{
		return $this->belongsTo(Project::class);
	}

	public function relationships(): BelongsToMany
	{
		return $this->belongsToMany(Character::class, 'character_relationships', 'character_id', 'related_character_id')
			->withPivot('character_role', 'related_character_role')
			->withTimestamps();
	}

	public function inverseRelationships(): BelongsToMany
	{
		return $this->belongsToMany(Character::class, 'character_relationships', 'related_character_id', 'character_id')
			->withPivot('character_role', 'related_character_role')
			->withTimestamps();
	}

	public function allRelationships()
	{
		$this->load(['relationships', 'inverseRelationships']);
    	return $this->relationships->merge($this->inverseRelationships);
	}

	public function collections()
    {
        return $this->hasManyThrough(
            Collection::class,
            CollectionItem::class,
            'collectionable_id', // Foreign key on collection_items table
            'id', // Foreign key on collections table
            'id', // Local key on characters table
            'collection_id' // Local key on collection_items table
        )->where('collection_items.collectionable_type', 'App\Models\Character');
    }

	public function customFields()
	{
		return $this->morphMany(CustomField::class, 'fieldable');
	}

	public function customFieldValues(): HasMany
	{
		return $this->hasMany(CustomFieldValue::class, 'fieldable_id');
	}

	public function factions(): BelongsToMany
	{
		return $this->belongsToMany(Faction::class, 'faction_members')->withPivot('rank_id');
	}

	public function location()
	{
		return $this->belongsTo(Location::class, 'location_id');
	}

	/**
	 * Media relationships.
	 * @return \Illuminate\Database\Eloquent\Relations\Relation
	 */

	public function image()
	{
		return $this->portrait();
	}
	public function media(): MorphMany
	{
		return $this->morphMany(Media::class, 'mediable');
	}
	public function portrait(): MorphOne
	{
		return $this->morphOne(Media::class, 'mediable')->where('type', 'portrait');
	}
	public function banner(): MorphOne
	{
		return $this->morphOne(Media::class, 'mediable')->where('type', 'banner');
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
