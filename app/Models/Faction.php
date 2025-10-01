<?php

namespace App\Models;

use App\Models\Pivots\FactionMember;
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

class Faction extends Model
{

    use HasUuids, HasFactory, Sluggable, SoftDeletes;



	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'name',
		'description',
		'starred',
		'emblem'
	];



	/**
	 * The attributes that should not be mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $guarded = [
		'project_id'
	];



	/**
	 * Set up faction relationships.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\Relation
	 */
	
	public function project(): BelongsTo
	{
		return $this->belongsTo(Project::class);
	}

	

	public function headquarters(): BelongsTo
	{
		return $this->belongsTo(Location::class, 'headquarters_id');
	}
	
	public function members(): BelongsToMany
	{
		return $this->belongsToMany(Character::class, 'faction_members')
			->using(FactionMember::class)
			->withPivot(['rank_id']);
	}

	public function ranks(): HasMany
	{
		return $this->hasMany(FactionRank::class);
	}

	public function customFields()
	{
		return $this->morphMany(CustomField::class, 'fieldable');
	}

	/**
	 * Media relationships.
	 * @return \Illuminate\Database\Eloquent\Relations\Relation
	 */

	public function image()
	{
		return $this->emblem();
	}
	public function media(): MorphMany
	{
		return $this->morphMany(Media::class, 'mediable');
	}
	public function emblem(): MorphOne
	{
		return $this->morphOne(Media::class, 'mediable')->where('type', 'emblem');
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
