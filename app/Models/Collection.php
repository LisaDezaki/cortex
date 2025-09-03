<?php

namespace App\Models;

use App\Models\CollectionItem;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Collection extends Model
{

	use HasUuids, Sluggable;

    // use HasFactory;

	public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */

	 protected $fillable = [
		'name',
		'collection_type',
		'description',
		'tags'
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

	public function items()
	{
        return $this->hasMany(CollectionItem::class);
    }

	public function characters()
    {
        return $this->items()
            ->where('collectionable_type', 'App\Models\Character')
            ->with('collectionable')
            ->orderBy('order');
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
