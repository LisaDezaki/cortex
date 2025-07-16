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

class Character extends Model
{
	use HasUuids, HasFactory, Sluggable, SoftDeletes;

	protected $fillable = [
		'name',
		'subtitle',
		'description',
		'appearance',
		'personality',
		'motivations',
		'flaws',      
		'location_id',
		'image'
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

	// public function customFields(): HasMany
	// {
	// 	return $this->hasMany(CustomField::class, 'project_id')
	// 		->where('entity_type', 'character');
	// }

	public function customFieldValues(): HasMany
	{
		return $this->hasMany(CustomFieldValue::class, 'entity_id');
	}

	public function factions(): BelongsToMany
	{
		return $this->belongsToMany(Faction::class, 'faction_members')
			->withPivot('rank_id');
	}

	public function location()
	{
		return $this->belongsTo(Location::class, 'location_id');
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
