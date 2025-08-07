<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
	use HasUuids, HasFactory, Notifiable;

	protected $fillable = [
		'name',
		'email',
		'avatar_id',
		'password',
		'active_project'
	];

	protected $with = [
		'avatar'
	];

	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	 * Get the attributes that should be cast.
	 *
	 * @return array<string, string>
	 */
	protected function casts(): array
	{
		return [
			'email_verified_at' => 'datetime',
			'password' => 'hashed',
		];
	}

	/**
	 * Set up user relationships.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\Relation
	 */
	
	
	public function projects(): HasMany
	{
		return $this->hasMany(Project::class);
	}

	public function activeProject()
	{
		return Project::where('id', $this->active_project)->first();
	}

	/**
	 * Set up media relationships.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\Relation
	 */

	public function avatar()
	{
		return $this->morphOne(Media::class, 'mediable')
			->where('type', 'user_avatar');
	}

}