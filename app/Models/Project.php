<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

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
		'type',
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
		'type' => 'string',
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

	public function collections(): HasMany
	{
		return $this->hasMany(Collection::class);
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

	public function locations(): HasMany
	{
		return $this->hasMany(Location::class)->orderBy('slug', 'ASC');
	}



	public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }
	public function banner(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')->where('type', 'banner');
    }
	public function gallery(): MorphMany
	{
		return $this->morphMany(Media::class, 'mediable')->where('type', 'gallery');
	}
}