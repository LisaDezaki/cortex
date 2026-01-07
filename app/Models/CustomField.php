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
		'fieldable_type',
		'type',
		'name',
		'description',
		'placeholder',
		'required',
		'options',
		'min',
		'max'
	];

	protected $guarded = [
		'project_id',
	];

	protected $casts = [
		'type' => 'string',
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

	public function fieldable(): MorphTo
	{
		return $this->morphTo();
	}

	public function options(): HasMany
	{
		return $this->hasMany(CustomFieldOption::class);
	}

	public function hasOptions()
	{
		return $this->type === 'select';
	}


}
