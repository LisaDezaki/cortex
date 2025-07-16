<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
		'entity_type',
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

	 public function project()
	 {
		 return $this->belongsTo(Project::class);
	 }

	 public function options()
	 {
		return $this->hasMany(CustomFieldOption::class);
	 }



}
