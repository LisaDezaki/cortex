<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{

	
	use HasUuids, HasFactory, SoftDeletes;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'name',
		'description',
	];

	/**
	 * The attributes that should not be mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $guarded = [
		'user_id'
	];

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array<int, string>
	 */
	protected $hidden = [];

	/**
	 * Get the attributes that should be cast.
	 *
	 * @return array<string, string>
	 */
	protected $casts = [
		'name' => 'string',
		'description' => 'string'
	];

	/**
	 * Set up project relationships.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\Relation
	 */



	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	public function customFields(): HasMany
	{
		return $this->hasMany(CustomField::class);
	}

	public function characters(): HasMany
	{
		return $this->hasMany(Character::class)->orderBy('slug', 'ASC');
	}

	public function factions(): HasMany
	{
		return $this->hasMany(Faction::class)->orderBy('slug', 'ASC');
	}

	public function regions(): HasMany
	{
		return $this->hasMany(Region::class);
	}

	// public function locations(): HasMany
	// {
	// 	return $this->hasMany(Location::class)->orderBy('slug', 'ASC');
	// }

	public function locations()
	{
		return $this->hasManyThrough(
			Location::class, // Target model (locations)
			Region::class,   // Intermediate model (regions)
			'project_id',   // Foreign key on regions table
			'region_id',   // Foreign key on locations table
			'id',           // Local key on projects table
			'id'      // Local key on regions table
		)->orderBy('locations.slug', 'ASC');
	}

	public function banner()
    {
        return $this->morphOne(Media::class, 'mediable')
			->where('type', 'project_banner');
    }
	
	public function gallery()
	{
		return $this->morphMany(Media::class, 'mediable')
			->where('type', 'project_gallery');
	}
}