<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CustomFieldValue extends Model
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
		'value',
	];

	protected $guarded = [
		'custom_field_id',
		'entity_id',
	];



	/**
	 * Set up relationships.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\Relation
	 */

	public function customField()
	{
		return $this->belongsTo(CustomField::class);
	}

	public function entity()
	{
		$entity = $this->customField->entity_type;
		return $this->belongsTo($entity, 'entity_id', 'uuid');
	}



}
