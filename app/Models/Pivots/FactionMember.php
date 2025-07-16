<?php

namespace App\Models\Pivots;

use App\Models\FactionRank;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class FactionMember extends Pivot
{
	/**
	 * Set up faction relationships.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\Relation
	 */
	public function rank()
    {
        return $this->belongsTo(FactionRank::class, 'rank_id');
    }
	
}