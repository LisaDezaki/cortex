<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class CustomField extends Model
{

	use HasUuids;

    // use HasFactory;

	public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */

	 protected $fillable = [
		'customfieldable_type',
		'type',
		'name',
		'description',
		'placeholder',
		'required',
		'options'
	];

	protected $guarded = [
		'project_id',
	];



	/**
	 * Set up relationships.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\Relation
	 */

	public function project(): BelongsTo
	{
		return $this->belongsTo(Project::class);
	}

	public function customfieldable(): MorphTo
	{
		return $this->morphTo();
	}

	public function options(): HasMany
	{
		return $this->hasMany(CustomFieldOption::class);
	}


}
