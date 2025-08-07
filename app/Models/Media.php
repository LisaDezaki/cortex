<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids; 
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
	use HasUuids;

    protected $fillable = [
        'disk',
        'path',
        'filename',
        'mime_type',
        'size',
        'type',
		'mediable_type',
		'mediable_id',
        'metadata',
    ];
    
    protected $casts = [
        'metadata' => 'array',
    ];
    
    // Delete physical file when media record is deleted
    // protected static function booted()
    // {
    //     static::deleting(function ($media) {
    //         if ($media->isForceDeleting()) {
    //             Storage::disk($media->disk)->delete($media->filepath);
    //         }
    //     });
    // }
    
    // URL accessor
    public function getUrlAttribute()
    {
        return Storage::url($this->path);
    }
    
    // Relationship to any model
    public function mediable()
    {
        return $this->morphTo();
    }
}