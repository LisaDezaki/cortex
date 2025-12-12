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
		'custom_field_id',
		'fieldable_id',
		'value',
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
		$entity = $this->customField->fieldable_type;
		return $this->belongsTo($entity, 'fieldable_id', 'uuid');
	}

	public function getDisplayValue()
	{
		if (gettype($this->value) === 'boolean') {
			return $this->value ? 'true' : 'false';
		}

		if (!$this->customField->hasOptions()) {
			return $this->value;
		}
		
		$option = $this->customField->options
			->firstWhere('value', $this->value);
			
		return $option ? $option->label : $this->value;
	}

}
