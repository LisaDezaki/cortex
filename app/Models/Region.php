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

class Region extends Model
{
	use HasUuids, Sluggable, SoftDeletes;



	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'name',
		'description',
		'image'
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
	 * Set up character relationships.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\Relation
	 */
	public function project(): BelongsTo
	{
		return $this->belongsTo(Project::class, 'project_id');
	}

	public function locations(): HasMany
	{
		return $this->hasMany(Location::class);
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
