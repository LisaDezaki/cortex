<?php

namespace App\Models;

use App\Models\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\DB;

class CollectionItem extends Model
{
	public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */

	protected $table = 'collection_items';

	protected $fillable = [
		'collection_id',
		'collectionable_type',
		'collectionable_id',
		'order',
		'notes'
	];



	/**
	 * Set up relationships.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\Relation
	 */

	public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }
    
    public function collectionable(): MorphTo
    {
        return $this->morphTo();
    }

	// public function project(): BelongsTo
	// {
	// 	return $this->belongsTo(Project::class);
	// }

	// public function collection()
	// {
	// 	return $this->belongsToMany(Collection::class, 'collection_items', 'collectionable_id', 'collection_id');
	// }

	// public function item(): MorphTo
    // {
    //     return $this->morphTo(__function__, 'collectionable_type', 'collectionable_id');
    // }

	// Relationship to any model
    // public function collectionable()
    // {
    //     return $this->morphTo();
    // }


}
