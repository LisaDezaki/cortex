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
	use HasFactory, Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'name',
		'email',
		'avatar',
		'password',
		'active_project'
	];

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array<int, string>
	 */
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

	// public function unpackProject()
	// {
	// 	$project = Project::where('id', $this->active_project)->first();
	// 	// $project->characters = $project->characters()->with(['factions', 'location'])->get();
	// 	// $project->characters->each(function ($character) {
	// 	// 	$character->all_relationships = $character->relationships->merge($character->inverseRelationships);
	// 	// 	unset($character->relationships);
	// 	// 	unset($character->inverseRelationships);
	// 	// });
	// 	// $project->factions = $project->factions()->with(['members'])->get();
	// 	// $project->locations = $project->locations()->get();
	// 	// $project->custom_fields = $project->customFields()->with('options')->get();

	// 	return $project;
	// }

}