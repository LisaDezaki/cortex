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

class FactionRank extends Model
{
    use HasUuids;

	public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'order',
		'name',
		'description'
	];



	/**
	 * The attributes that should not be mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $guarded = [
		'faction_id'
	];



	/**
	 * Set up faction relationships.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\Relation
	 */
	public function faction(): BelongsTo
	{
		return $this->belongsTo(Faction::class);
	}
	public function members(): BelongsToMany
	{
		return $this->belongsToMany(FactionMember::class, 'faction_ranks')
			->withPivot(['faction_id']);
	}


	public function outranks(FactionRank $rank)
	{
		return $this->order > $rank->order;
	}

	
}
